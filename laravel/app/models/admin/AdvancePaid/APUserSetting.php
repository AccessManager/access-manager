<?php

class APUserSetting extends BaseModel {

	protected $table = 'ap_user_settings';
	protected $fillable = ['user_id','percent_check','percent'];
	public $timestamps = FALSE;
	
}
//end of file APUserSetting.php