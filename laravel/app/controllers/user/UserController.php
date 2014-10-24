<?php

Class UserController extends UserBaseController {

	const HOME = 'user-panel';
	
	public function getIndex()
	{

		return View::make('user.dashboard')
					->with('profile', Auth::user());
	}

	public function getRecharge()
	{
		$plans = Plan::with('limit')->paginate(10);
		return View::make('user.recharge')
					->with('plans', $plans);
	}

	public function postRecharge()
	{
		try {
			$voucher_type = Input::get('voucher_type', NULL);
			$pin = Input::get('pin', NULL);

			if( $voucher_type == NULL ) throw new Exception("Select Voucher Type.");
			if( $pin == NULL ) throw new Exception("Please enter a valid PIN");

			switch($voucher_type) {
				case 'prepaid' :
					Recharge::viaPin($pin, Auth::id() );
				break;
				case 'refill' :
					Refillcoupons::viaPin($pin, Auth::id() );
				break;
			}
			return Redirect::route(self::HOME);
		}
			catch(Exception $e)
			{
				$this->notifyError($e->getMessage());
				return Redirect::back();
			}
	}

	public function getRechargeHistory()
	{
		$rc_history = Subscriber::find(Auth::id())
								->rechargeHistory()
								->with('limits')
								->orderby('updated_at','desc')
								->paginate(10);

		return View::make('user.recharge_history')
					->with('rc_history', $rc_history);
	}

	public function getSessionHistory()
	{
		$sess_history = Subscriber::find(Auth::id())
									->sessionHistory()
									->orderby('acctstarttime','desc')
									->paginate(10);
		return View::make('user.session_history')
					->with('sess_history', $sess_history);
	}

	public function getChangePassword()
	{
		return View::make('user.change_password');
	}

	public function postChangePassword()
	{
		$user_id = Input::get('user_id', 0);
		$current = Input::get('current', NULL);

		$user = Subscriber::findOrFail($user_id);
		if( $user->clear_pword != $current ) {
			$this->notifyError("Incorrect current password.");
			return Redirect::back();
		}

		$password = Input::get('password', NULL);
		$confirm = Input::get('confirm_password', NULL);
		if( $password != $confirm ) {
			$this->notifyError("New password & confirm password do not match.");
			return Redirect::back();
		}

		$user->clear_pword = $password;
		$user->pword = Hash::make($password);

		if($user->save()) {
			$this->notifySuccess("Password Updated.");
		} else {
			$this->notifyError("Password Updation Failed.");
		}
		return Redirect::back();
	}

}