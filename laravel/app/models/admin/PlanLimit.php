<?php

Class PlanLimit extends BaseModel {
	protected $table = 'plan_limits';
	protected $fillable = ['limit_type','time_limit','time_unit','data_limit','data_unit',
							'aq_access','aq_policy'];
	public $timestamps = false;

	// public function plan()
	// {
	// 	return $this->belongsTo('Plan','plan_id');
	// }
}