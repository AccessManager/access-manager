<?php

class OnlinePayment extends BaseModel {

	public static function getActivePaymentGateways()
	{
		$enabled_gateways = [];

		$direcpay = Direcpay::first();

		if( $direcpay->status == ENABLED )
			$enabled_gateways[] = 'DIRECPAY';

		return $enabled_gateways;
	}
}
//end of file OnlinePayment.php