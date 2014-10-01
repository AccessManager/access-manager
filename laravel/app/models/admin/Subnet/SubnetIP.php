<?php

class SubnetIP extends BaseModel {

	protected $table = 'subnet_ips';
	protected $fillable = ['subnet_id','user_id','ip','assigned_on'];
	public $timestamps = FALSE;
}
//end of file SubnetIP.php