<?php

class APTransaction extends BaseModel {

	protected $table = 'ap_transactions';
	protected $fillable = ['user_id','type','amount','description'];
	
	
}