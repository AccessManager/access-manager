<?php

class APNonRecurringProduct extends BaseModel {

	protected $table = 'ap_user_non_recurring_products';
	protected $fillable = ['user_id','name','assigned_on','price','taxable','tax_rate'];
	public $timestamps = FALSE;
}
//end of file APNonRecurringProduct.php