<?php

Validator::extend('less_than', function($attribute, $value, $parameters){

	return $value < $parameters[0];
},"Value of :field should be less than :compared");

Validator::extend('greater_than', function($attribute, $value, $parameters){
	return $value > $parameters[0];
}, "Value of :field should be greater than :compared");

Validator::replacer('less_than', function($message, $attribute, $value, $parameters){
	$temp = str_replace(':field', $attribute, $message);
	return str_replace(':compared', $parameters[0], $temp);
});

Validator::replacer('greater_than', function($message, $attribute, $value, $parameters){
	$temp = str_replace(':field', $attribute, $message);
	return str_replace(':compared', $parameters[0], $temp);
});
	
return [
'accounts'			=>		[
				'uname'	=>	['required','alpha_dash','sometimes',],
				'pword'	=>	['required','min:6','max:20','sometimes',],
				'fname'	=>	['alpha'],
				'lname'	=>	['alpha'],
			  'contact' =>	['numeric'],
				'email'	=>	['required','email'],
			   'status' =>	['required'],
],
'generate_vouchers'		=>	[
					'plan_id'	=>	['required','integer'],
					'count'	=>	['required','numeric'],
				'validity'	=>	['required','numeric'],
			'validity_unit'	=>	['required','in:days,months'],
],
'recharge_account'		=>	[
			'user_id'	=>	['required','numeric','exists:user_accounts,id'],
			'plan_id'		=>	['required','numeric','exists:service_plans,id'],
],
'service_plan'			=>	[
					'name'		=>		['required','alpha_dash',],
					'plan_type'	=>		['required','in:0,1'],
				'policy_type'	=>		['required','in:Policy,PolicySchema'],
					'policy_id'	=>		['required','integer'],
				'sim_sessions'	=>		['required','numeric'],
			'interim_updates'	=>		['required','numeric'],
					'validity'	=>		['required','numeric'],
				'validity_unit'	=>		['required','in:Days,Months'],
					'price'		=>		['required','numeric'],
				'limit_type'	=>		['required_if:plan_type,1'],
				'time_limit'	=>		['required_if:limit_type,0','required_if:limit_type,2','numeric'],
				'time_unit'		=>		['required_if:limit_type,0','required_if:limit_type,2','in:Hrs,Mins'],
				'data_limit'	=>		['required_if:limit_type,1','required_if:limit_type,2','numeric'],
				'data_unit'		=>		['required_if:limit_type,1','required_if:limit_type,2','in:MB,GB'],
				'aq_access'		=>		['sometimes','in:0,1'],
				'aq_policy'		=>		['required_if:aq_access,1'],

],
'schema_templates'		=>	[
		   'name'	=>	['required','alpha_dash'],
		 'access'	=>	['required','in:0,1,2'],
	  'bw_policy'	=>	['required_if:access,0'],
 'bw_accountable'	=>	['in:0,1'],
	  'from_time'	=>	['required_if:access,2','required_with:to_time',], //'different:to_time'
	    'to_time'	=>	['required_if:access,2','required_with:from_time',], //'different:from_time'
 	 'pr_allowed'	=>	['in:0,1'],
    'sec_allowed'	=>	['in:0,1'],
	  'pr_policy'	=>	['required_with:pr_allowed'],
	 'sec_policy'	=>	['required_with:sec_allowed'],
 'pr_accountable'	=>	['in:0,1'],
'sec_accountable'	=>	['in:0,1'],
				],
'policies'			=>	[
	'name'	=>	['required','alpha_dash'],
	'max_down'		=>	['required','numeric'],
	'max_down_unit'	=>	['required'],
	'min_down'		=>	['required','numeric'],
	'min_down_unit'	=>	['required'],
	'max_up'		=>	['required','numeric'],
	'max_up_unit'	=>	['required'],
	'min_up'		=>	['required','numeric'],
	'min_up_unit'	=>	['required'],
				],
'policy_schemas'	=>	[
	'name'			=>	['required','alpha_dash'],
	'mo'			=>	['required','numeric','exists:policy_schema_templates,id'],
	'tu'			=>	['required','numeric','exists:policy_schema_templates,id'],
	'we'			=>	['required','numeric','exists:policy_schema_templates,id'],
	'th'			=>	['required','numeric','exists:policy_schema_templates,id'],
	'fr'			=>	['required','numeric','exists:policy_schema_templates,id'],
	'sa'			=>	['required','numeric','exists:policy_schema_templates,id'],
	'su'			=>	['required','numeric','exists:policy_schema_templates,id'],
				],
'admin_password'	=>	[
	'current'		=>	['required'],
	'password'		=>	['required',],
	'confirm'		=>	['required','same:password'],
				]
];