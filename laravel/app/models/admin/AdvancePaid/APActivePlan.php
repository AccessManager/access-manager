<?php

class APActivePlan extends BaseModel {
	
	protected $table = 'ap_active_plans';
	protected $fillable = ['user_id','assigned_on','billing_cycle','billing_unit','last_billed_on',
							'plan_name','plan_type','limit_id','policy_type','policy_id',
						'sim_sessions','interim_updates','time_balance','data_balance','aq_invocked',
						'active_tpl','price','validity','validity_unit'];
	public $timestamps = FALSE;

	public function limit()
	{
		return $this->belongsTo('APLimit','limit_id');
	}

	public function policy()
	{
		return $this->morphTo();
	}

	public static function AssignPlan($user_id, $plan_id, $price = NULL)
	{
		DB::transaction(function()use($user_id,$plan_id, $price){

			$oldPlan = APActivePlan::where('user_id',$user_id)
							->first();
			if( ! is_null($oldPlan) ) {
				self::updatePlanHistory($oldPlan);
			} else {
				$oldPlan = new ApActivePlan();
			}
			$plan = Plan::findOrFail($plan_id);

			$newPlan = [
						 'user_id'	=>		$user_id,
					   'plan_name'	=>		$plan->name,
					   'plan_type'	=>		$plan->plan_type,
					 'policy_type'	=>		$plan->policy_type,
					'sim_sessions'	=>		$plan->sim_sessions,
				 'interim_updates'	=>		$plan->interim_updates,
					 'aq_invocked'	=>		0,
		   				   'price'	=>		$plan->price,
					'time_balance'	=>		NULL,
					'data_balance'	=>		NULL,
					 'assigned_on'	=>		date("Y-m-d H:i:s"),
					 	'validity'	=>		$plan->validity,
				   'validity_unit'	=>		$plan->validity_unit,
			];
			if( $price != NULL ) {
				$newPlan['price'] = $price;
			}
				if( $plan->plan_type == LIMITED ) {
					$limit = $plan->limit;
					if( $limit->limit_type == TIME_LIMIT || $limit->limit_type == BOTH_LIMITS )
						$newPlan['time_balance'] = $limit->time_limit * constant($limit->time_unit);
					if( $limit->limit_type == DATA_LIMIT || $limit->limit_type == BOTH_LIMITS )
						$newPlan['data_balance'] = $limit->data_limit * constant($limit->data_unit);
					
					if( $limit->aq_access == ALLOWED ) {
						$aq_policy = Policy::findOrFail($limit->aq_policy);
						$limit->aq_policy = mikrotikRateLimit($aq_policy->toArray());
					}
					$planLimit = APLimit::create($limit->toArray());
					$newPlan['limit_id'] = $planLimit->id;
				}

			if( $plan->policy_type == 'Policy' ) {
				$policy = APPolicy::create(['bw_policy'=> mikrotikRateLimit($plan->policy->toArray())]);
			} elseif ( $plan->policy_type == 'PolicySchema' ) {
				$days = [
							'mo'	=>	'monday',
							'tu'	=>	'tuesday',
							'we'	=>	'wednesday',
							'th'	=>	'thursday',
							'fr'	=>	'friday',
							'sa'	=>	'saturday',
							'su'	=>	'sunday',
				];
				foreach( $days as $d ) {
					$tpl = $plan->policy->{$day}->toArray();
					$types = ['bw_policy','pr_policy','sec_policy'];
					foreach($types as $t ) {
						if( ! is_null($tpl[$t] ) ) {
							$policy = Policy::find($tpl[$t])->toArray();
							$tpl[$t] = mikrotikRateLimit($policy);
						}
					}
					$template = APPolicySchemaTemplate::create($tpl);
					$schema[$d] = $template->id;
				}
				$policy = APPolicySchema::create($schema);
			}
			$newPlan['policy_id'] = $policy->id;
			$oldPlan->fill($newPlan);
			$oldPlan->save();
			return TRUE;
		});
	}

	private static function updatePlanHistory($oldPlan)
	{
		$data = [
				 'user_id' 	=> 		$oldPlan->user_id,
			   'from_date'	=>		$oldPlan->assigned_on,
				 'to_date'	=>		date('Y-m-d H:i:s'),
			   'plan_name'	=>		$oldPlan->plan_name,
				   'price'	=>		$oldPlan->price,
		];

		$settings = APSetting::first();

		if( $settings->plan_taxable )
			$data['tax_rate']	= 	$settings->plan_tax_rate;
		
		if( $oldPlan->plan_type == LIMITED ) {
			$data = array_merge($data, $oldPlan->limit->toArray());
		}
		if ( ! APChangeHistory::create($data) )
			throw new Exception("Could not save service plan history." . __FILE__ . __LINE__ );
	}

}

//end of file APActivePlan.php