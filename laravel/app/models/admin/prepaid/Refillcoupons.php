<?php
use AccessManager\Radius\Account\Account as RadiusAccount;
use AccessManager\Radius\UserAccount as RadiusUserAccount;

class Refillcoupons extends BaseModel {

	protected $table = 'refill_coupons';
	protected $fillable = ['pin','user_id','expires_on','aq_invocked',
							'have_data','data_limit','data_unit',
							'have_time','time_limit','time_unit',];

	public static function getAll()
	{
		return DB::table('refill_coupons as c')
						->leftJoin('user_accounts as u','u.id','=','c.user_id')
						->select("u.uname",'c.*')
						->orderby('created_at','DESC')
						->paginate(10);
	}

	public static function generate( $postData )
	{
		$postData['expires_on'] = AccessManager::makeExpiry($postData['validity'], $postData['validity_unit']);
		return DB::transaction(function()use($postData){
			for( $i = 0; $i < $postData['count']; $i++ ) {
				$postData['pin'] = self::_generatePin();
				if( ! $coupon = static::create($postData) )	throw new Exception("Voucher Creation Failed.");
				$pins[] = $coupon->pin;
			}
			return $pins;
		});
	}

	private static function _generatePin()
	{
		do {
			$pin = mt_rand(1111111,99999999999);
			$exists = static::where('pin', $pin)->count();
		} while($exists);
		return $pin;
	}

	public static function variables($ids)
	{
		return DB::table('refill_coupons as c')
					->select('c.have_time','c.have_data','c.expires_on','c.created_at',
						DB::raw('CONCAT(c.time_limit,c.time_unit) as time_limit'),
						DB::raw('CONCAT(c.data_limit,c.data_unit) as data_limit')
						)
					->whereIn('c.id',$ids)
					->get();
	}

	public static function viaPin($pin, $uid)
	{
			DB::transaction(function() use($pin, $uid){
				if( ! Refillcoupons::now($pin, $uid) )	throw new Exception('Recharge Failed.');
				$updateCount = Refillcoupons::where('pin',$pin)
									->update([
											'user_id'	=>		$uid,
										]);
				if( ! $updateCount )	throw new Exception('Voucher Updation Failed.');
			});
			return TRUE;
	}

	public static function refillOnline($uid, $data)
	{
		DB::transaction(function()use($uid, $data){
			$temp = [
						'validity'	=>	1,
					'validity_unit'	=>	'Days',
							'count'	=>	1,
			];
			$data = array_merge($data, $temp);

			if( ! $pins = self::generate($data) )	throw new Exception('Refill Failed. Phase:1');
			$pin = current($pins);
			if( ! self::now( $pin, $uid, 'online') )	throw new Exception("Refill Failed. Phase:2");
			if( ! Refillcoupons::where('pin',$pin)->update(['user_id'=>$uid]) )	throw new Exception('Refill Failed. Phase:3');
		});
	}

	public static function now($pin, $uid, $method='pin')
	{
		$coupon = self::where('pin',$pin)->first();
		if( $coupon == NULL )	throw new Exception("Invalid PIN.");
		if( $coupon->user_id != NULL )	throw new Exception('Invalid/Used Voucher.');
			
		$subscriber = Subscriber::find($uid);

		switch($subscriber->plan_type) {

			case PREPAID_PLAN :
				$recharge = DB::table('user_recharges as r')
							->where('r.user_id', $uid)
							->join('prepaid_vouchers as v','r.voucher_id','=','v.id')
							->join('user_accounts as u','u.id','=','r.user_id')
							->leftJoin('voucher_limits as l','v.limit_id','=','l.id')
							->select('r.id','v.plan_type','v.limit_id','r.expiration','l.aq_access','u.uname')
							->first();
				if( is_null($recharge) )	throw new Exception("Cannot refill, account never recharged.");
				if( strtotime($recharge->expiration) < time() )	
					throw new Exception(
						"Cannot recharge account, validity expired on: " . date('d-M-y H:i', strtotime($recharge->expiration))
						);
				if( $recharge->plan_type == UNLIMITED )
					throw new Exception('Cannot refill Unlimited Account.');
				return self::refillPrepaid($coupon, $recharge);
				break;

			case FREE_PLAN :
				$balance = Freebalance::where('free_balance.user_id', $uid)
								->join('user_accounts as u','u.id','=','free_balance.user_id')
								->select('free_balance.plan_type','free_balance.limit_type','free_balance.id','free_balance.aq_access',
									'free_balance.aq_invocked',
									'free_balance.time_balance','free_balance.data_balance','free_balance.expiration','u.uname')
								->first();
								
				if( strtotime($balance->expiration) < time() )	
					throw new Exception(
						"Cannot refill account, validity expired on: " . date('d-M-y H:i', strtotime($balance->expiration))
					);
				if( $balance->plan_type == UNLIMITED )
					throw new Exception("Cannot refill unlimited account.");
				return self::refillFree($coupon, $balance);
				break;
		}
	}

	public static function refillPrepaid($coupon, $recharge)
	{
		$limit = VoucherLimit::findOrFail($recharge->limit_id);
		$balance = Recharge::findOrFail($recharge->id);

		if( ( $coupon->have_time && $coupon->have_data ) && $limit->limit_type != BOTH_LIMITS )
			throw new Exception("Coupon having both Time and Data can only be applied to account having both limits.");
		if( ( $coupon->have_time && ! $coupon->have_data ) && $limit->limit_type != TIME_LIMIT )
			throw new Exception("Time Balance coupons can only be applied to accounts with Time Limit.");
		if( ( $coupon->have_data && ! $coupon->have_time ) && $limit->limit_type != DATA_LIMIT )
			throw new Exception("Data Balance coupons can only be applied to account with Data Limit");

		$result = FALSE;
		if( $coupon->have_time && ($limit->limit_type == TIME_LIMIT || $limit->limit_type == BOTH_LIMITS )) {
			if($limit->time_limit >= 0 ) {
				$balance->increment('time_limit', $coupon->time_limit * constant($coupon->time_unit));
			} else {
				$balance->time_limit = $coupon->time_limit * constant($coupon->time_unit);
				$balance->save();
			}
			$result = TRUE;
		}

		if( $coupon->have_data && ($limit->limit_type == DATA_LIMIT || $limit->limit_type == BOTH_LIMITS )) {
			if( $limit->data_limit >= 0 ) {
				$balance->increment('data_limit', $coupon->data_limit * constant($coupon->data_unit));
			} else {
				$balance->data_limit = $coupon->data_limit * constant($coupon->data_unit);
				$balance->save();
			}
			$result = TRUE;
		}
		if( $result == TRUE && $recharge->aq_access == ALLOWED ) {
			DB::table('user_recharges')
				->where(['user_id'=>$recharge->id])
				->update(['aq_invocked'	=>	0,]);
				$this->_invokeCoA($recharge->uname);
		}
		return $result;
	}

	public static function refillFree($coupon, $balance)
	{
		if( ( $coupon->have_time && $coupon->have_data ) && $balance->limit_type != BOTH_LIMITS )
			throw new Exception("Coupon having both Time and Data can only be applied to account having both limits.");

		$result = FALSE;
		if( $coupon->have_time && ($balance->limit_type == TIME_LIMIT || $balance->limit_type == BOTH_LIMITS )) {
			if( $balance->time_balance >= 0 ) {
				$newTime = $coupon->time_balance * constant($coupon->time_unit);
				if( ! $balance->increment('time_balance', $newTime) ) throw new Exception('Could not increment Time');
				$result = TRUE;
			} else {
				$balance->time_balance = $coupon->time_limit * constant($coupon->time_unit);
				if( ! $balance->save() ) throw new Exception('Could not update Time');
				$result = TRUE;
			}
		}

		if( $coupon->have_data && ($balance->limit_type == DATA_LIMIT || $balance->limit_type == BOTH_LIMITS )) {

			if( $balance->data_balance >= 0 ) {
				$newBalance = $coupon->data_limit * constant($coupon->data_unit);
				if( ! $balance->increment('data_balance', $newBalance) ) throw new Exception('Could not increment data.');
				$result = TRUE;
			} else {
				$balance->data_balance = $coupon->data_limit * constant($coupon->data_unit);
				if( ! $balance->save() ) throw new Exception('Could not update Data.');
				$result = TRUE;
			}
		}
		if( $result == TRUE && $balance->aq_access == ALLOWED ) {
				DB::table('free_balance')
					->where(['id'=>$balance->id])
					->update(['aq_invocked'=>0]);
				self::_invokeCoA($balance->uname);
		}
		return $result;
	}

	private static function _invokeCoA($uname)
	{
		$user = new RadiusUserAccount($uname);
				$plan = $user->getActivePlan();
				$plan->fetchPlanDetails();
				$account = new RadiusAccount($plan);
				$account->CoA( TRUE );
	}

}

//end of file Refillcoupons.php