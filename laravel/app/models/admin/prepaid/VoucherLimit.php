<?php

Class VoucherLimit extends BaseModel {

	protected $table = 'voucher_limits';

	protected $fillable = ['limit_type','time_limit','time_unit','data_limit','data_unit',
							'aq_access','aq_policy','aq_max_down','aq_max_down_unit','aq_min_down',
							'aq_min_down_unit','aq_max_up','aq_max_up_unit','aq_min_up',
							'aq_min_up_unit'];
							
	public $timestamps = false;
}