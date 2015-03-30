<?php
use Symfony\Component\Process\Process;

Class Subscriber extends BaseModel {

	protected $table = 'user_accounts';
	protected $fillable = ['uname','clear_pword','pword','plan_type',
							'fname','lname','contact','plan_type',
							'email','address','status',];

	public function recharge()
	{
		return $this->hasOne('Recharge', 'user_id');
	}

	public function rechargeHistory()
	{
		return $this->hasMany('Voucher', 'user_id');
	}

	public function sessionHistory()
	{
		return $this->hasMany('RadAcct', 'username', 'uname');
	}

	public static function getActiveSessionPlans($sessions)
	{
		$plans = [];
		if( ! is_null($sessions) ) {
			foreach( $sessions as $user ) {
				switch( $user->plan_type ) {
					case FREE_PLAN :
						$plan = Freebalance::select('expiration')
										->where('user_id', $user->id)
										->first();
						$plan->plan_name = 'FRiNTERNET';
					break;
					case PREPAID_PLAN :
					$plan = DB::table('user_recharges as r')
									->where('r.user_id',$user->id)
									->join('prepaid_vouchers as v','v.id','=','r.voucher_id')
									->select('r.expiration','v.plan_name')
									->first();
					break;
					case ADVANCEPAID_PLAN :
					$plan = DB::table("ap_active_plans as p")
								->join('billing_cycles as b','b.user_id','=','p.user_id')
								->where('b.user_id',$user->id)
								->select('b.expiration','p.plan_name')
								->first();
					break;
				}
				$plans[$user->session_id] = $plan;
			}
		}
		return $plans;
	}

	public static function updateFreePlan($user_id)
	{
		$free_balance = Freebalance::where('user_id', $user_id)->first();
		if( ! is_null( $free_balance ) )	return;

		$free_balance = new Freebalance(['user_id'=>$user_id]);

		$free_plan = FRINTERNET::select('plan_type','limit_type','time_limit','time_unit'
								,'data_limit','data_unit','validity','validity_unit','policy_id',
								'limit_type','aq_access','aq_policy','sim_sessions','interim_updates',
								'reset_every','reset_unit')
								->first();
		$new_balance = [
			'last_reset_on' => date('Y-m-d H:i:s'),
			'expiration'	=> makeExpiry($free_plan->validity, $free_plan->validity_unit, 'd M Y H:i'),
			'bw_policy'		=>	mikrotikRateLimit(Policy::find($free_plan->policy_id)->toArray()),
			'plan_type'		=>	$free_plan->plan_type,
			'limit_type'	=>	$free_plan->limit_type,
			'time_limit'	=>	$free_plan->time_limit,
			'time_unit'		=>	$free_plan->time_unit,
			'data_limit'	=>	$free_plan->data_limit,
			'data_unit'		=>	$free_plan->data_unit,
			'aq_access'		=>	$free_plan->aq_access,
			'sim_sessions'	=>	$free_plan->sim_sessions,
			'interim_updates'	=>	$free_plan->interim_updates,
			'reset_every'	=>	$free_plan->reset_every,
			'reset_unit'	=>	$free_plan->reset_unit,
			'aq_invocked'	=>	0,
			'time_balance'	=>	NULL,
			'data_balance'	=>	NULL,
		];
		if( $free_plan->plan_type == LIMITED ) {
			if($free_plan->aq_access)
				$new_balance['aq_policy'] = mikrotikRateLimit(Policy::find($free_plan->aq_policy)->toArray());
			if( $free_plan->limit_type == TIME_LIMIT || $free_plan->limit_type == BOTH_LIMITS )
				$new_balance['time_balance'] = $free_plan->time_limit * constant($free_plan->time_unit);
			if( $free_plan->limit_type == DATA_LIMIT || $free_plan->limit_type == BOTH_LIMITS )
				$new_balance['data_balance'] = $free_plan->data_limit * constant($free_plan->data_unit);
		}
		$free_balance->fill($new_balance);
		$free_balance->save();
	}

	public static function getActiveServices(Subscriber $profile)
	{
		switch($profile->plan_type) {
			case PREPAID_PLAN:
			return DB::table('user_recharges as r')
						->where('r.user_id', $profile->id)
						->select('r.time_limit','r.data_limit','recharged_on','r.expiration',
							'plan_name','plan_type','l.limit_type')
						->join('prepaid_vouchers as v','v.id','=','r.voucher_id')
						->leftJoin('voucher_limits as l','l.id','=','v.limit_id')
						->first();
			break;
			case FREE_PLAN :
			return Freebalance::where('user_id', $profile->id)
								->select('plan_type','limit_type','time_balance as time_limit',
									'data_balance as data_limit','expiration','last_reset_on')
								->first();
			break;
			case ADVANCEPAID_PLAN :
			return DB::table('ap_active_plans as p')
							->where('p.user_id',$profile->id)
							->select('plan_type','limit_type','time_balance as time_limit',
								'data_balance as data_limit','plan_name','c.expiration')
							->leftJoin('ap_limits as l','l.id','=','p.limit_id')
							->join('billing_cycles as c','c.user_id','=','.p.user_id')
							->first();
			break;
			default:
			throw new Exception("Failed to identify service type: {$profile->plan_type}");
			break;
		}
	}

	public static function destroySession($session_id)
	{
		$session = DB::table('radacct as a')
						->join('nas as n','n.nasname','=','a.nasipaddress')
						->select('a.framedipaddress','a.username','a.nasipaddress','n.secret')
						->where('radacctid', $session_id)
						->first();
		$exec = "echo \" User-Name={$session->username}, Framed-IP-Address={$session->framedipaddress} \" ".
                                     "| radclient {$session->nasipaddress}:3799 disconnect {$session->secret}";
        $process = new Process($exec);
        $process->mustRun();
	}

	public static function destroyAllSessions(Subscriber $user)
	{
		$sessions = DB::table('radacct as a')
						->join('nas as n','n.nasname','=','a.nasipaddress')
						->where('a.username',$user->uname)
						->where('a.acctstoptime', NULL)
						->select('a.framedipaddress','a.nasipaddress','n.secret')
						->orderby('a.acctstarttime')
						->get();
		if( ! is_null($sessions) ) {
			foreach( $sessions as $session ) {
				$exec = "echo \" User-Name={$user->uname}, Framed-IP-Address={$session->framedipaddress} \" ".
		                                     "| radclient {$session->nasipaddress}:3799 disconnect {$session->secret}";
		        $process = new Process($exec);
		        $process->mustRun();
			}
		}
	}


}

//end of file Subscriber.php