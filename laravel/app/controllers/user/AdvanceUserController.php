<?php

class AdvanceUserController extends UserBaseController {

	const HOME = 'advancepaid.dashboard';

	public function dashboard()
	{
		$subscriber = Subscriber::find(Auth::id());
		$plan = Subscriber::getActiveServices($subscriber);
		return View::make('user.advancepaid.dashboard')
					->with('profile', Auth::user())
					->with('plan', $plan);
	}

	public function sessionHistory()
	{
		$sess_history = Subscriber::find(Auth::id())
									->sessionHistory()
									->orderby('acctstarttime','desc')
									->paginate(10);
		return View::make('user.advancepaid.session_history')
					->with('sess_history', $sess_history);
	}
}
//end of file AdvanceUserController.php