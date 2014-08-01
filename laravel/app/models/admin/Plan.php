<?php

Class Plan extends BaseModel {
	protected $table = 'service_plans';
	protected $fillable = ['name','plan_type','policy_type','policy_id','validity',
							'validity_unit','sim_sessions','interim_updates','price'];

	public function limit()
	{
		return $this->hasOne('PlanLimit','plan_id');
	}

	public function policy()
	{
		return $this->morphTo();
	}

	public function delete()
	{
		$this->limit()->delete();

		return parent::delete();
	}

	// public function schema()
	// {
	// 	return $this->hasOne('PolicySchema','schema_id');
	// }
}