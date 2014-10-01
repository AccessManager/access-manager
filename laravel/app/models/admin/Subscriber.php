<?php

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

	public static function updateFreePlan($user_id)
	{
		$free_balance = Freebalance::where('user_id', $user_id)->first();
		if( ! is_null( $free_balance ) )	return;

		$free_balance = new Freebalance(['user_id'=>$user_id]);

		$free_plan = FRINTERNET::select('plan_type','limit_type','time_limit','time_unit'
								,'data_limit','data_unit','validity','validity_unit','policy_id',
								'limit_type','aq_access','aq_policy','sim_sessions','interim_updates')
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
		$recharge = Recharge::where('user_id', $user_id)
								->first();
		if( ! is_null($recharge) )
		$recharge->delete();
	}

	public static function updatePrepaidPlan($user_id)
	{

		$recharge = Recharge::where('user_id', $user_id)
									->first();
		// if( ! is_null($recharge) )
		// $recharge->delete();
		$free_balance = Freebalance::where(['user_id'=>$user_id])->first();
		if( ! is_null($free_balance) )
			$free_balance->delete();
	}

	// public static function addAccount($input)
	// {
	// 	$account = new Subscriber;
	// 	$account->fill($input);

	// 	if( ! $account->save() ) {
	// 		throw new Exception("Account creation failed.");
	// 	}
	// }
}