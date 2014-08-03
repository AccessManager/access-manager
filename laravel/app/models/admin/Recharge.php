<?php

class Recharge extends BaseModel {

	protected $table = 'user_recharges';
	protected $fillable = ['user_id','voucher_id','recharged_on',
							'time_limit','data_limit','expiration','sim_sessions','aq_access'];
	public $timestamps = false;

	public function account()
	{
		return $this->belongsTo('Subscriber', 'user_id');
	}

	public static function viaAdmin($input)
	{
			  $temp['plan_id'] = $input['plan_id'];
				$temp['count'] = 1;
			 $temp['validity'] = 1;
		$temp['validity_unit'] = 'days';
			  $temp['user_id'] = $input['user_id'];

		try{
			DB::transaction(function() use($temp) {
				if ( ! $pins = Voucher::generate($temp) ) {
					throw new Exception("Voucher Generation Failed.");
				}
				if( ! self::now( current($pins), $temp['user_id'], 'admin') ) {
					throw new Exception("Failed to recharge account.");
				}
			});
			Notification::success("Account Successfully Recharged");
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			Notification::error($e->getMessage());
		}
		catch(Exception $e) {
			Notification::error($e->getMessage());
		}
	}

	public static function viaPin($pin, $uid)
	{
		try{
			DB::transaction(function() use($pin, $uid){
				self::now($pin, $uid);
			});
			Notification::success("Account Successfully Recharged.");
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			Notification::error($e->getMessage());
		}
		catch(Exception $e) {
			Notification::error($e->getMessage());
		}
	}

	public static function now($pin, $uid, $method = 'pin')
	{
		$voucher = Voucher::where('pin',$pin)->firstOrFail();

		$rc['voucher_id'] = $voucher->id;
		$rc['recharged_on'] = date('Y-m-d H:i:s');
		// $rc['plan_type'] = $voucher->plan_type;
		$rc['aq_invocked'] = 0;
		$rc['expiration'] = AccessManager::makeExpiry($voucher->validity, $voucher->validity_unit, 'd M Y H:i');

		$rc['time_limit'] = NULL;
		$rc['data_limit'] = NULL;

		if($voucher->plan_type == 1 ) { //if limited

			$limit = $voucher->limits;
			// $rc['limit_type'] = $limit->limit_type;
			if($limit->limit_type == 0 || $limit->limit_type == 2 ) {
				$rc['time_limit'] = $limit->time_limit * constant($limit->time_unit);
			}

			if( $limit->limit_type == 1 || $limit->limit_type == 2 ) {
				$rc['data_limit'] = $limit->data_limit * constant( $limit->data_unit);
			}
		}

		$recharge = Recharge::firstOrNew(['user_id'=>$uid]);
			$recharge->fill($rc);
			if( ! $recharge->save() )	return FALSE;
			$voucher->fill(['user_id'=>$uid,'method'=>$method]);
			if( ! $voucher->save() )	return FALSE;

			return TRUE;
	}
}