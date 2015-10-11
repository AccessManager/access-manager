<?php
use Symfony\Component\Process\Exception\ProcessFailedException;

Class AccountsController extends AdminBaseController {

	const HOME = 'subscriber.index';

	public function getActive()
	{
		$q = DB::table('radacct as a')
				->select('u.id','u.uname','u.fname','u.lname','u.contact',
						'a.acctstarttime','a.radacctid as session_id','u.plan_type')
				->join('user_accounts as u','u.uname','=','a.username')
				->orderby('u.uname')
				->where('a.acctstoptime', NULL);

		$alphabet = Input::get('alphabet', NULL);
		if( !is_null($alphabet) ) {
			$q->where('u.uname','LIKE',"$alphabet%");
		}
		$sessions = $q->paginate(10);
		
		$plans = Subscriber::getActiveSessionPlans($sessions);

		return View::make('admin.accounts.dashboard')
					->with('active', $sessions)
					->with('plans', $plans);
	}

	public function clearStaleSessions()
	{
		$sessions = RadAcct::where('acctstoptime', NULL)
					->get();

		foreach( $sessions as $session ) {
			$startTime = strtotime($session->acctstarttime);
			if( $startTime + $session->acctsessiontime + 86400 < time() ) {
				$stopTime = date('Y-m-d H:i:s', $startTime + $session->acctsessiontime );

				$session->acctstoptime = $stopTime;

				$session->save();
			}
		}
		return Redirect::back();
	}

	public function getInvoiceByNumber( $number )
	{
		$invoice = APInvoice::where(['invoice_number'=>$number])->firstOrFail();
		$pdf = new PDFInvoice( $invoice );
		return $pdf->render();
	}

	public function getInvoiceById( $id )
	{
		$invoice = APInvoice::find( $id );
		$pdf = new PDFInvoice($invoice);
		return $pdf->render();
	}

	public function postDisconnect()
	{
        try {
        	$session_id = Input::get('session_id');
        	Subscriber::destroySession($session_id);
        }
        catch(ProcessFailedException $e) {
        	$this->notifyError($e->getMessage());
        	return Redirect::back();
        }
        $this->notifySuccess("Session Disconnected.");
		return Redirect::back();
	}

	public function getIndex()
	{
		$q = Subscriber::with('Recharge')
								->where('is_admin',0)
								->orderby('uname');
		$alphabet = Input::get('alphabet', NULL);
		if( ! is_null($alphabet) ) {
			$q->where('uname','LIKE',"$alphabet%");
		}
		return View::make('admin.accounts.index')
							->with('accounts',$q->paginate(10));
	}

	public function postSearch()
	{
		$keyword = Input::get('keyword', NULL);
		$q = Subscriber::with('Recharge')
							->where('uname','LIKE',"%$keyword%")
							->orderby('uname');
							
		return View::make("admin.accounts.search-result")
						->with('accounts',$q->paginate(10));
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
			$input['plan_type'] = PREPAID_PLAN;
			
			$account = Subscriber::create($input);

			$this->notifySuccess("New Subscriber added successfully: <b>{$input['uname']}</b>");
			return $this->getProfile($account->id);
		}
		catch(Exception $e) {
			$this->notifyError($e->getMessage());
			return Redirect::route(self::HOME);
		}
		
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
			if( $account->status == DEACTIVE ) {
				Subscriber::destroyAllSessions($account);
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
		$this->notifyError("Operation Not Permitted.");
		return Redirect::back();
		//////////////////////////////////////////////////////
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
			$profile = Subscriber::with('Recharge')->findOrFail($id);
			
			$sess_history = $profile->sessionHistory()
									->orderby('acctstarttime', 'DESC')
									->paginate(5);

			return View::make('admin.accounts.profile')
						->with('profile',$profile)
						->with('sess_history', $sess_history);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function getAssignPlan($user_id)
	{
		$profile = Subscriber::findOrFail($user_id);
		$plans = Plan::lists('name','id')
					->orderby('name');
		return View::make("admin.accounts.assign-plan")
					->with('profile', $profile)
					->with('plans', $plans);
	}

	public function postAssignPlan()
	{
		try{
			$user_id = Input::get('user_id', 0);
			$plan_id = Input::get('plan_id', 0);
			$price = Input::get('price', NULL);
			APActivePlan::AssignPlan($user_id, $plan_id, $price);
			$this->notifySuccess("Plan Assigned.");
		}
		catch(Exception $e) {
			$this->notifyError($e->getMessage());
			return Redirect::route("subscriber.services",$user_id);
		}
		return Redirect::route("subscriber.services",$user_id);

	}

	public function getActiveServices($user_id)
	{
		$profile = Subscriber::findOrFail($user_id);
		$plan = Subscriber::getActiveServices($profile);
		$framedIP = SubnetIP::where('user_id',$user_id)->first();
		$framedRoute = UserRoute::where('user_id',$user_id)->first();
		switch( $profile->plan_type ) {
			case FREE_PLAN:
			case PREPAID_PLAN:
			$rc_history = Voucher::where('user_id', $user_id)
							->leftJoin('voucher_limits as l','l.id','=','limit_id')
							->paginate(5);
			return View::make("admin.accounts.services")
					->with('profile', $profile)
					->with('rc_history', $rc_history)
					->with('plan', $plan)
					->with('framedIP',$framedIP)
					->with('framedRoute', $framedRoute);
			break;
			case ADVANCEPAID_PLAN:
			$rproducts = APRecurringProduct::where('user_id', $profile->id)->get();
			$nrproducts = APNonRecurringProduct::where('user_id', $profile->id)->get();

			return View::make('admin.accounts.services-ap2')
					->with('profile', $profile)
					->with('plan', $plan)
					->with('framedIP',$framedIP)
					->with('framedRoute', $framedRoute)
					->with('rproducts', $rproducts)
					->with('nrproducts', $nrproducts);
			
			break;
		}

	}

	public function getTransactions( $user_id )
	{
		$profile = Subscriber::findOrFail($user_id);
		$txns = APTransaction::where('user_id', $user_id )
								->orderby('created_at','DESC')
								->paginate(10);

		$view = View::make('admin.accounts.ap-transactions',['txns'=>$txns,'profile'=>$profile]);

		$ap_settings = APUserSetting::where('user_id', $user_id)->first();
			if( $ap_settings != NULL )
				$view->with('ap_settings', $ap_settings);
			return $view;
	}

	public function postAddTransaction()
	{
		$txn = new APTransaction;

		$txn->fill(Input::all());
		if($txn->save()) {
			$this->notifySuccess('Transaction Successful.');
		} else {
			$this->notifyError('Transaction Failed.');
		}
		return Redirect::back();
	}

	public function postAPSettings()
	{
		$settings = APUserSetting::firstOrNew(['user_id' => Input::get('user_id',0) ]);
		$settings->fill( Input::all() );
		if( $settings->save() ) {
			$this->notifySuccess('Settings Updated.');
		} else {
			$this->notifyError('Settings updation failed.');
		}
		return Redirect::back();
	}

	public function postResetPassword()
	{
		$pword = Input::get('npword');
		$id = Input::get('id');

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

	public function getChangeServiceType($user_id)
	{
		$profile = Subscriber::findOrFail($user_id);
		$orgs = Organisation::lists('name','id');
		return View::make("admin.accounts.change-service-type")
					->with('profile', $profile)
					->with('orgs',$orgs);
	}

	public function postChangeServiceType()
	{
		try {
			// pr(Input::all());
			$user_id = Input::get('user_id');
			$user = Subscriber::findOrFail( $user_id );
			$disconnect = new stdClass;
			$disconnect->set = FALSE;
			DB::transaction(function()use($user, $disconnect){
				$plan_type = Input::get('plan_type');
				if( $user->plan_type != $plan_type)	$disconnect->set = TRUE;
				
				$user->plan_type = $plan_type;
				if( ! $user->save() )	throw new Exception('Failed to change service type.');
				if( $user->plan_type == ADVANCEPAID_PLAN ) {
					$billing = BillingCycle::firstOrNew(['user_id'=>$user->id]);
					$input = Input::all();
					$input['expiration'] = date("Y-m-d H:i:s", strtotime($input['expiration']));
					$billing->fill($input);
					if( ! $billing->save() )	throw new Exception("Failed to save billing cycle details.");
					// pr($billing->toArray());
				}
				if( $user->plan_type == FREE_PLAN ) {
					Subscriber::updateFreePlan($user->id);
				}
			});
			if( $disconnect->set ) {
				Subscriber::destroyAllSessions($user);
			}
			$this->notifySuccess("Service Type Updated.");
		}
		catch(Exception $e)
		{
			$this->notifyError($e->getMessage());
			return Redirect::route('subscriber.profile', $user_id);
		}
		return Redirect::route('subscriber.profile', $user_id);
	}

	public function postRefill()
	{
		
	}
	
}