<?php

class OnlineRechargeController extends UserBaseController {


	public function selectPaymentGateway()
	{
		$data = Input::all();
		Session::flash('post_data',$data);
		$planType = Auth::user()->plan_type == PREPAID_PLAN ? 'prepaid' : 'frinternet';
		$activeGateways = OnlinePayment::getActivePaymentGateways();

		return View::make('user.select_pg')
					->with('activeGateways', $activeGateways)
					->with('planType',$planType)
					;
	}

	public function initiateOnlineRecharge()
	{
		$gw = Input::get('gateway');
		$post_data = Session::get('post_data');

		switch($gw) {
			case 'DIRECPAY' :
			$dp = new DirecpayController;
			return $dp->processDirecpay( $post_data );
			break;

		}
	}



}
//end of file OnlineRechargeController.php