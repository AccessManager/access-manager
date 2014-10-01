<?php

class Freebalance extends BaseModel {

	protected $table = 'free_balance';
	protected $fillable = ['user_id','bw_policy','plan_type','limit_type','time_limit','time_unit',
						'time_balance','data_limit','data_unit','data_balance','aq_access','aq_policy',
						'sim_sessions','interim_updates','reset_every','reset_unit',
						'last_reset_on','expiration','aq_invocked'];
	public $timestamps = false;
	
}