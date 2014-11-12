<?php

Class LoginController extends AdminBaseController {

	public function getIndex()
	{
		return View::make('user.login');
	}

	public function postLogin()
	{
		if(Auth::attempt([
					'uname'		=>		Input::get('uname'),
					'password'	=>		Input::get('pword'),
					'is_admin'	=>		0
			]) )
			return Redirect::intended('user-panel');

		Session::flash('error', "Invalid Credentials");
		return Redirect::back()->withInput();
	}

	public function getAdmin()
	{
		return View::make('admin.login');
	}

	public function postAdmin()
	{
		if( Auth::attempt([
				   'uname'	=>	Input::get('uname'),
				'password'	=>	Input::get('pword'),
				'is_admin'	=>	1
			]) )
			return Redirect::intended('admin-panel');

		Session::flash('error', "Invalid Username/Password");
		return Redirect::back()->withInput();
	}

	public function postInternetLogin()
	{
		Session::flash( 'mac', 			Input::get('mac', 				NULL) );
		Session::flash( 'ip', 			Input::get('ip', 				NULL) );
		Session::flash( 'username', 	Input::get('username', 			NULL) );
		Session::flash( 'linklogin', 	Input::get('link-login', 		NULL) );
		Session::flash( 'linkorig', 	Input::get('link-orig', 		NULL) );
		Session::flash( 'chapid', 		Input::get('chap-id', 			NULL) );
		Session::flash( 'chapchallenge',Input::get('chap-challenge', 	NULL) );
		Session::flash( 'linkloginonly',Input::get('link-login-only', 	NULL) );
		Session::flash( 'linkorigesc', 	Input::get('link-orig-esc', 	NULL) );
		Session::flash( 'macesc', 		Input::get('mac-esc', 			NULL) );

		$error = Input::get('error', NULL);
		return View::make('login-template')
					->with('error', $error);
	}

	public function postAuthorizeInternetLogin()
	{
		$data = [];

		$data['mac'] 				= Session::get('mac');
		$data['ip'] 				= Session::get('ip');
		$data['linklogin'] 			= Session::get('linklogin');
		$data['linkorig'] 			= Session::get('linkorig');
		$data['chapid'] 			= Session::get('chapid');
		$data['chapchallenge'] 		= Session::get('chapchallenge');
		$data['linkloginonly'] 		= Session::get('linkloginonly');
		$data['linkorigesc'] 		= Session::get('linkorigesc');
		$data['macesc'] 			= Session::get('macesc');
		$data['username']			= Input::get('username' );
		$data['password']			= Input::get('password');

		//Do All Authorization stuff here.

		return View::make('internet-authorized')
						->with('data', $data);
	}

}