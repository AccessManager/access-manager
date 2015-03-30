<?php

class APSetting extends BaseModel {
	
	protected $table = 'ap_settings';
	protected $fillable = ['payment_due_in_days','disconnection_status','plan_taxable','plan_tax_rate',
							'disconnection_days','due_amount_penalty_status','due_amount_penalty_min',
							'due_amount_penalty_percent'];
	public $timestamps = FALSE;

}