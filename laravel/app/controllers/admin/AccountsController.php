<?php

Class AccountsController extends AdminBaseController {

	const HOME = 'subscriber.index';

	public function getActive()
	{
		$q = DB::table('radacct as a')
				->select('u.uname','u.fname','u.lname','u.contact',
						// 'r.expiration', 
						'a.acctstarttime')
				->join('user_accounts as u','u.uname','=','a.username')
				// ->join('user_recharges as r','u.id','=','r.user_id')
				// ->join('prepaid_vouchers as v', 'r.voucher_id','=','v.id')
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
			
			$account = Subscriber::create($input);
			if( $account->plan_type == FREE_PLAN )
				Subscriber::updateFreePlan($account->id);

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
			if( ! $account->save() )	throw new Exception("Failed to update account.");
			
			switch($account->plan_type) {
				case FREE_PLAN :
				Subscriber::updateFreePlan($account->id);
				break;
				case PREPAID_PLAN :
				Subscriber::updatePrepaidPlan($account->id);
				break;
			}
			$this->notifySuccess("Account successfully updated.");
		}
		catch(Exception $e) {
			$this->notifyError( $e->getMessage() );
			return Redirect::route(self::HOME);
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
			$sess_history = $profile->sessionHistory()->paginate(10);

			return View::make('admin.accounts.profile')
						->with('profile',$profile)
						->with('rc_history', $rc_history)
						->with('sess_history', $sess_history);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function getAssignPlan($user_id)
	{
		$profile = Subscriber::findOrFail($user_id);
		$plans = Plan::lists('name','id');
		return View::make("admin.accounts.assign-plan")
					->with('profile', $profile)
					->with('plans', $plans);
	}

	public function postAssignPlan()
	{
		$user_id = Input::get('user_id', 0);
		$plan_id = Input::get('plan_id', 0);
		APActivePlan::AssignPlan($user_id, $plan_id);
		return Redirect::back();

	}

	public function getActiveServices($user_id)
	{
		$profile = Subscriber::findOrFail($user_id);
		if( $profile->plan_type == PREPAID_PLAN ) {
			$plan = DB::table('user_recharges as r')
							->where('r.user_id', $user_id)
							->select('r.time_limit','r.data_limit','recharged_on','r.expiration',
								'plan_name','plan_type','l.limit_type')
							->join('prepaid_vouchers as v','v.id','=','r.voucher_id')
							->leftJoin('voucher_limits as l','l.id','=','v.limit_id')
							->first();
		}
		if( $profile->plan_type == FREE_PLAN ) {
			$plan = Freebalance::where('user_id', $user_id)->first();
		}
		if( $profile->plan_type == ADVANCEPAID_PLAN ) {
			$plan = APActivePlan::where('user_id',$user_id)
							->select('plan_type','limit_type','time_balance as time_limit',
								'data_balance as data_limit','plan_name')
							->join('ap_limits as l','l.id','=','ap_active_plans.limit_id')
							->first();
		}
		$framedIP = SubnetIP::where('user_id',$user_id)->first();
		$framedRoute = UserRoute::where('user_id',$user_id)->first();
		return View::make("admin.accounts.services")
					->with('profile', $profile)
					->with('plan', $plan)
					->with('framedIP',$framedIP)
					->with('framedRoute', $framedRoute);
	}

	public function postResetPassword()
	{
		$pword = Input::get('npword');
		$id = Input::get('id');

		// pr(Input::all());
		$affectedRows =	Subscriber::where('id', $id)
					->update([
							'pword'		=>	Hash::make($pword),
						'clear_pword'	=>	$pword,
						]);
		if($affectedRows) {
			$this->notifySuccess("Password Changed.");
		} else {
			$this->notifyError("Failed to change password.");
		}
		return Redirect::back();
	}

	public function postRefill()
	{
		
	}
	
}