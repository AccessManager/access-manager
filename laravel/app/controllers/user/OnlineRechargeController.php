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
		$plan = Plan::findOrFail($post_data['plan_id']);
		switch($gw) {
			case 'DIRECPAY' :
			$dp = new DirecpayController;
			return $dp->processDirecpay($plan->price,[
															'type'	=>'recharge',
														'plan_name'	=>$plan->plan_name,
														  'plan_id'	=>$plan->id
														]);
			break;

		}
	}



}
//end of file OnlineRechargeController.php