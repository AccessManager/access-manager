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

}