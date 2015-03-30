<?php

class APUserRecurringProductHistory extends BaseModel {

	protected $table = 'ap_user_recurring_products_history';
	protected $fillable = ['user_id','name','start_date','stop_date','price','taxable','tax_rate','billed_every'];
	public $timestamps = FALSE;
}
//end of file APUserProductHistory.php