<?php

Class UserController extends UserBaseController {

	const HOME = 'user.panel';
	
	public function getIndex()
	{
		return View::make('user.dashboard')
					->with('profile', Auth::user());
	}

	public function getChangePassword()
	{
		$plan_type = NULL;
		switch( Auth::user()->plan_type ) {
			case PREPAID_PLAN :
				$plan_type = 'prepaid';
			break;
			case FREE_PLAN :
				$plan_type = 'frinternet';
			break;
			case ADVANCEPAID_PLAN :
				$plan_type = 'advancepaid';
			break;
		}
		return View::make('user.prepaid.change_password',['plan_type'=>$plan_type]);
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