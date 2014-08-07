<?php

Class AccountsController extends AdminBaseController {

	const HOME = 'subscriber.index';

	public function getActive()
	{
		$q = DB::table('radacct as a')
				->select('u.uname','u.fname','u.lname','u.contact',
						'r.expiration', 'a.acctstarttime','v.plan_name')
				->join('user_accounts as u','u.uname','=','a.username')
				->join('user_recharges as r','u.id','=','r.user_id')
				->join('prepaid_vouchers as v', 'r.voucher_id','=','v.id')
				->where('a.acctstoptime', NULL);

		$alphabet = Input::get('alphabet', NULL);
		if( !is_null($alphabet) ) {
			$q->where('u.uname','LIKE',"$alphabet%");
		}
		return View::make('admin.accounts.dashboard')
					->with('active', $q->paginate(10));
	}

	public function getIndex()
	{
		$accounts = Subscriber::with('Recharge')
								->where('is_admin',0)->paginate(10);
								
		return View::make('admin.accounts.index')
							->with('accounts',$accounts);
	}

	public function getAdd()
	{
		return View::make('admin.accounts.add-edit');
	}

	public function postAdd()
	{
		try {
			$input = Input::all();
		
			$rules = Config::get('validations.accounts');
			$rules['uname'][] = 'unique:user_accounts';
			
			$v = Validator::make($input, $rules);
			$v->setAttributeNames( Config::get('attributes.accounts') );
			if( $v->fails() )
				return Redirect::back()
								->withInput()
								->withErrors($v);

			$input['clear_pword'] = $input['pword'];
			$input['pword'] = Hash::make($input['pword']);
			
			Subscriber::create($input);

			$this->notifySuccess("New Subscriber added successfully: <b>{$input['uname']}</b>");
		}
		catch(Exception $e) {
			$this->notifyError($e->getMessage());
			return Redirect::route(self::HOME);
		}
		return Redirect::route(self::HOME);
	}

	public function getEdit($id)
	{
		try{
			$account = Subscriber::findOrFail($id);
			return View::make('admin.accounts.add-edit')
									->with('account',$account);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postEdit()
	{
		$input = Input::all();
		$rules = Config::get('validations.accounts');
		$rules['uname'][] = 'unique:user_accounts,uname,' . $input['id'];

		$v = Validator::make($input, $rules);
		$v->setAttributeNames( Config::get('attributes.accounts') );
		if( $v->fails() )
			return Redirect::back()
							->withInput()
							->withErrors($v);
		try{
			if( ! Input::has('id')) throw new Exception("Required parameter missing: ID");

			$account = Subscriber::find($input['id']);
			if( ! $account )		throw new Exception("No such user with id:{$input['id']}");
			$account->fill($input);
			if( ! $account->save() )	throw new Exception("Account creation failed.");
			$this->notifySuccess("Account successfully updated.");
		}
		catch(Exception $e) {
			$this->notifyError( $e->getMessage() );
			// return Redirect::route(self::HOME);
		}
		return Redirect::route(self::HOME);
	}

	public function postDelete($id)
	{
		try{
			DB::transaction(function() use($id) {
				if( ! Subscriber::destroy($id) ||
					( Recharge::where('user_id',$id)->count() && ! Recharge::where('user_id',$id)->delete() )
				) throw new Exception("Account could not be deleted, please try again.");
			});
			$this->notifySuccess("Account Successfully deleted.");
			return Redirect::route(self::HOME);
		}
		catch(Exception $e) {
			$this->notifyError($e->getMessage());
			return Redirect::route(self::HOME);
		}
	}

	public function getProfile($id)
	{
		try{
			$profile = Subscriber::findOrFail($id);
			$rc_history = $profile->rechargeHistory()->take(5)->get();
			$sess_history = $profile->sessionHistory()->take(5)->get();

			return View::make('admin.accounts.profile')
						->with('profile',$profile)
						->with('rc_history', $rc_history)
						->with('sess_history', $sess_history);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postResetPassword()
	{
		pr(Input::all());
	}

	public function postRefill()
	{
		
	}
	
}