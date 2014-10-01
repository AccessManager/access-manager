<?php

class FRINTERNET extends BaseModel {

	protected $table = 'free_plan';

	protected $fillable = ['limit_bw','policy_id','plan_type','limit_type',
						'time_limit','time_unit','data_limit','data_unit',
						'aq_access','aq_policy','sim_sessions','interim_updates',
						'reset_every','reset_unit','validity','validity_unit'];
	public $timestamps = FALSE;
}