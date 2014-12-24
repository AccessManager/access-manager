<?php
use RAHULMKHJ\PaymentGateways\Direcpay\Direcpay as DP;

class DirecpayController extends BaseController {

	private $postData;

	public function processDirecpay($postData)
	{

		$this->postData = $postData;
		try {
			$details = $this->_makeDetails();
			
			$order_id = DirecpayTransaction::initiate( Auth::id(), $details );
			$user = Auth::user();

			$dp = new DP;
			$settings = DB::table('direcpay_settings')->first();
			if( $settings->sandbox == ENABLED ) {
				$dp->enableSandbox();
			} else {
				$dp->setMerchant( $settings->mid, $settings->enc_key );
			}
			$dp->setRequestParameters([
							'amount'	=>		$details['amount'],
						   'orderNo'	=>		$order_id,
						'successUrl'	=>		$details['successUrl'],
						'failureUrl'	=>		$details['failureUrl'],
				]);
			$dp->setBillingDetails([
						'name'		=>		$user->fname . " " . $user->lname,
						'address'	=>		$user->address,
						'city'		=>		'Solan',
						'state'		=>		'Himachal Pradesh',
						'pinCode'	=>		173205,
						'country'	=>		'IN',
						'mobileNo'	=>		$user->contact,
						'emailId'	=>		$user->email,
				]);
			$dp->setOtherDetails( $this->postData );

			$dp->buildEncryptedStrings(TRUE);
			$dp->autoSubmit();
			$dp->generateForm();
			
		} catch(Exception $e) {
			$this->notifyError( $e->getMessage() );
			return Redirect::back();
		}
	}

	private function _makeDetails()
	{
		$details = [];
		switch($this->postData['type']) {
			case 'recharge':
				$details = $this->_makeRechargeDetails();
			break;
			case 'refill':
				$details = $this->_makeRefillDetails();
			break;
		}
		return array_merge( $details, $this->_makeReturnUrl() );
	}

	private function _makeRechargeDetails()
	{
		$plan = Plan::find($this->postData['plan_id']);
			return [
				 	'type'		=>		'recharge',
			   'plan_name'		=>		$plan->name,
			     'plan_id'		=>		$plan->id,
			     'amount'		=>		$plan->price,
			];

	}

	private function _makeRefillDetails()
	{
		return [
				  'type'	=>	'refill',
				 'value'	=>	$this->postData['data_limit'],
				  'unit'	=>	$this->postData['data_unit'],
				'amount'	=>	$this->postData['data_limit']*50,
			];	
	}

	private function _makeReturnUrl()
	{
		switch( Auth::user()->plan_type ) {
			case PREPAID_PLAN :
			return [
					'successUrl'	=>	route('direcpay.prepaid.response'),
					'failureUrl'	=>	route('direcpay.prepaid.response'),
			];
			break;
			case FREE_PLAN:
			return [
					'successUrl'	=>	route('direcpay.frinternet.response'),
					'failureUrl'	=>	route('direcpay.frinternet.response'),
			];
			break;
		}
	}

	public function prepaidResponse()
	{
		$response = DP::response(Input::all());
		DirecpayTransaction::updateResponse($response);
		if( $response->txnSucceed() ):
		$details = $response->getDetails();
		switch($details['type']) {
			case 'recharge':
				Recharge::online(Auth::id(), $details['plan_id']);
				$this->notifySuccess('Account Recharged.');
			break;
			case 'refill':
			try {
				Refillcoupons::refillOnline(Auth::id(), $details);
				$this->notifySuccess('Quota Refilled.');
			} catch(Exception $e) {
				$this->notifyError( $e->getMessage() );
				return Redirect::route('prepaid.dashboard');
			}
			
			break;
		}
		else:
			$this->notifyError('Transaction Failed.');
		endif;
		return Redirect::route('prepaid.dashboard');
	}

	public function frinternetResponse()
	{
		try {
			$response = DP::response(Input::all());
			DirecpayTransaction::updateResponse($response);
			$details = $response->getDetails();
			if( $response->txnSucceed() ):
				Refillcoupons::refillOnline(Auth::id(), $details);
				$this->notifySuccess('Account Refilled.');
			else:
				$this->notifyError('Account Refill Failed.');
			endif;
			return Redirect::route('frinternet.dashboard');
		} catch(Exception $e) {
			$this->notifyError($e->getMessage());
			return Redirect::route('frinternet.dashboard');
		}
	}

}
//end of file DirecpayController.php