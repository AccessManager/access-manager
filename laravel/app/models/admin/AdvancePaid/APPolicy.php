<?php

class APPolicy extends BaseModel {
	
	protected $table = 'ap_policies';
	protected $fillable = ['bw_policy'];
	public $timestamps = FALSE;

	public function plan()
	{
		return $this->morphMany('APActivePlan','policy');
	}
}