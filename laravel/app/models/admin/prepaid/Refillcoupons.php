<?php

class Refillcoupons extends BaseModel {

	protected $table = 'refill_coupons';
	protected $fillable = ['pin','user_id','expires_on',
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
		try {
			DB::transaction(function() use($pin, $uid){
				Refillcoupons::now($pin, $uid);
				$coupon = Refillcoupons::where('pin',$pin)
									->update([
											'user_id'	=>		$uid,
										]);
			});
			Notification::success("Refill coupon successfully applied.");
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			
			Notification::error($e->getMessage());
		}
		catch(Excepion $e) {
			Notification::error($e->getMessage());
		}

	}

	public static function now($pin, $uid, $method='pin')
	{
		$coupon = self::where('pin',$pin)->firstOrFail();
		if( $coupon->user_id != NULL ) {
			$this->notifyError("voucher already applied.");
		}
		$subscriber = Subscriber::find($uid);

		switch($subscriber->plan_type) {
			case PREPAID_PLAN :
				$recharge = DB::table('user_recharges as r')
							->where('r.user_id', $uid)
							->join('prepaid_vouchers as v','r.voucher_id','=','v.id')
							->select('r.id','v.plan_type','v.limit_id','r.expiration')
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
				$balance = Freebalance::where('user_id', $uid)
								->select('plan_type','limit_type','id',
									'time_balance','data_balance','expiration')
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

		if( ( $coupon->have_time && $coupon->have_data ) && $limit->limit_type != BOTH_LIMITS )
			throw new Exception("Coupon having both Time and Data can only be applied to account having both limits.");
		if( ( $coupon->have_time && ! $coupon->have_data ) && $limit->limit_type != TIME_LIMIT )
			throw new Exception("Time Balance coupons can only be applied to accounts with Time Limit.");
		if( ( $coupon->have_data && ! $coupon->have_time ) && $limit->limit_type != DATA_LIMIT )
			throw new Exception("Data Balance coupons can only be applied to account with Data Limit");

		if( $coupon->have_time && ($limit->limit_type == TIME_LIMIT || $limit->limit_type == BOTH_LIMITS )) {
			if($limit->time_limit >= 0 ) {
				$limit->increment('time_limit', $coupon->time_limit * constant($coupon->time_unit));
			} else {
				$limit->time_limit = $coupon->time_limit * constant($coupon->time_unit);
				$limit->save();
			}
		}

		if( $coupon->have_data && ($limit->limit_type == DATA_LIMIT || $limit->limit_type == BOTH_LIMITS )) {
			if( $limit->data_limit >= 0 ) {
				$limit->increment('data_limit', $coupon->data_limit * constant($coupon->data_unit));
			} else {
				$limit->data_limit = $coupon->data_limit * constant($coupon->data_unit);
				$limit->save();
			}
		}
	}

	public static function refillFree($coupon, $balance)
	{
		if( ( $coupon->have_time && $coupon->have_data ) && $balance->limit_type != BOTH_LIMITS )
			throw new Exception("Coupon having both Time and Data can only be applied to account having both limits.");
		if( ( $coupon->have_time && ! $coupon->have_data ) && $balance->limit_type != TIME_LIMIT )
			throw new Exception("Time Balance coupons can only be applied to accounts with Time Limit.");
		if( ( $coupon->have_data && ! $coupon->have_time ) && $balance->limit_type != DATA_LIMIT )
			throw new Exception("Data Balance coupons can only be applied to account with Data Limit");

		if( $coupon->have_time && ($balance->limit_type == TIME_LIMIT || $balance->limit_type == BOTH_LIMITS )) {
			if( $balance->time_balance >= 0 ) {
				$balance->increment('time_balance', $coupon->time_balance * constant($coupon->time_unit));
			} else {
				$balance->time_balance = $coupon->time_limit * constant($coupon->time_unit);
				$balance->save();
			}
		}

		if( $coupon->have_data && ($balance->limit_type == DATA_LIMIT || $balance->limit_type == BOTH_LIMITS )) {
			if( $balance->data_balance >= 0 ) {
				$newBalance = $coupon->data_limit * constant($coupon->data_unit);
				$balance->increment('data_balance', $newBalance );
			} else {
				$balance->data_balance = $coupon->data_limit * constant($coupon->data_unit);
				$balance->save();
			}
		}
	}

}

//end of file Refillcoupons.php