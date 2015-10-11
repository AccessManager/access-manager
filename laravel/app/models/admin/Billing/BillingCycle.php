<?php

class BillingCycle extends BaseModel {
	protected $table = 'billing_cycles';
	protected $fillable = ['user_id','billing_cycle','billing_unit','org_id',
							'last_billed_on','bill_date','expiration','bill_duration_type'];
	public $timestamps = FALSE;
}