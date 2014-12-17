<?php

class OnlinePayment extends BaseModel {

	protected $table = 'online_transactions';
	protected $fillable = ['user_id','gw_type','gw_id','amount','order_id',];

	public function gw()
	{
		return $this->morphTo();
	}

	public static function getActivePaymentGateways()
	{
		$enabled_gateways = [];

		$direcpay = DB::table('direcpay_settings')->first();

		if( $direcpay->status == ENABLED )
			$enabled_gateways[] = 'DIRECPAY';

		return $enabled_gateways;
	}
}
//end of file OnlinePayment.php