<?php

class BillingCycle extends BaseModel {
	protected $table = 'billing_cycles';
	protected $fillable = ['user_id','billing_cycle','billing_unit',
							'last_billed_on','bill_date','expiration'];
	public $timestamps = FALSE;
}