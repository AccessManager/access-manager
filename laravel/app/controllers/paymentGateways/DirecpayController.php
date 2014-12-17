<?php

class DirecpayController extends BaseController {

		public function processDirecpay( $amount, Array $details )
	{
		$user_id = Auth::id();
		try {
			$trans_id = DirecpayTransaction::initiate( $user_id, $amount, $details );
			$settings = DB::table('direcpay_settings')->first();
			$user = Subscriber::find($user_id);

			$dp = new RAHULMKHJ\PaymentGateways\Direcpay\Direcpay;

			if( $settings->sandbox == ENABLED ) {
				$dp->enableSandbox();
			} else {
				$dp->setMerchant( $settings->mid, $settings->enc_key );
			}
			$dp->setRequestParameters([
							'amount'	=>		$amount,
							'orderNo'	=>		$trans_id,
						'successUrl'	=>		route('direcpay.recharge.success'),
						'failureUrl'	=>		route('direcpay.recharge.failure'),
				]);
			$dp->setBillingDetails([
						'name'		=>		$user->fname . " " . $user->lname,
						'address'	=>		$user->address,
						'city'		=>		'Solan',
						'state'		=>		'Himachal Pradesh',
						'pinCode'	=>		173205,
						'country'	=>		'IN',
						'mobileNo'	=>		$user->contact,
						// 'phoneNo1'	=>		$user->contact,
						'emailId'	=>		$user->email,
				]);
			$dp->setOtherDetails($details);

			$dp->buildEncryptedStrings(TRUE);
			$dp->autoSubmit();
			$dp->generateForm();
			
		} catch(Exception $e) {
			$this->notifyError( $e->getMessage() );
			return Redirect::back();
		}
	}

	public function rechargeSuccess()
	{
		$dp = RAHULMKHJ\PaymentGateways\Direcpay\Direcpay::response(Input::all());
		if( $dp->txnSucceed() ) {
			$details = $dp->getDetails();

			DirecpayTransaction::succeed($dp);
			
			Recharge::online(Auth::id(), $details['plan_id']);
			$this->notifySuccess("Account Recharged.");
		} else {
			$this->notifyError("Account RechargeFailed.");
		}
		return Redirect::route('prepaid.dashboard');
	}

	public function rechargeFailure()
	{
		$dp = RAHULMKHJ\PaymentGateways\Direcpay\Direcpay::response(Input::all());
		
		if( $dp->txnFailed() ) {
			$this->notifyError("Transaction Failed. Contact Merchant.");
		}
		return Redirect::route('prepaid.dashboard');
	}
}
//end of file DirecpayController.php