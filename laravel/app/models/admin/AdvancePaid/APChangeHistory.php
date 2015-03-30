<?php

class APChangeHistory extends BaseModel {

	protected $table = 'ap_change_history';
	protected $fillable = ['user_id','from_date','to_date','plan_name','plan_type',
						'limit_type','time_limit','time_unit','data_limit','data_unit',
						'aq_access','aq_policy','price','tax_rate'];
	public $timestamps = FALSE;
}

//end of file APChangeHistory.php