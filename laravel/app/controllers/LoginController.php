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
			]) ) {
			$plan_type = Auth::user()->plan_type;
			switch( $plan_type ) {
				case PREPAID_PLAN :
					return Redirect::intended('prepaid-panel');
				break;
				case FREE_PLAN :
					return Redirect::intended('frinternet-panel');
				break;
				case ADVANCEPAID_PLAN :
					return Redirect::intended('advancepaid-panel');
				break;
			}
		} else {
			Session::flash('error', "Invalid Credentials");
			return Redirect::back()->withInput();
		}
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

	public function getSelfRegister()
	{
		$settings = GeneralSettings::first();

		if( ! $settings->self_signup ) {
			$this->notifyError("Self Signup Not Allowed.");
			return Redirect::route('user-panel');
		}
		return View::make('user.self-registration');
	}

	public function postSelfRegister()
	{
		$input = Input::only('uname','pword','pword_confirmation','status',
							'fname','lname','email','address','contact');
		$rules = Config::get('validations.accounts');
		$rules['uname'][] = 'unique:user_accounts';
		$rules['pword'][] = 'confirmed';

		$v = Validator::make($input, $rules);
		$v->setAttributeNames(Config::get('attributes.accounts') );

		if( $v->fails() )
			return Redirect::back()
							->withInput()
							->withErrors($v)
							;

		$input['plan_type'] 	= PREPAID_PLAN;
		$input['clear_pword']	= $input['pword'];
		$input['pword']			= Hash::make($input['pword']);
		$input['is_admin']		= 0;

		if( Subscriber::create($input) ) {
			Session::flash('success','succeed');
		}

		return Redirect::back();
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