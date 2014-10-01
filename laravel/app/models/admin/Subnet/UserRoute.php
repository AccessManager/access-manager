<?php

class UserRoute extends BaseModel {

	protected $table = 'user_routes';
	protected $fillable = ['user_id','subnet','assigned_on'];
	public $timestamps = FALSE;
}

//end of file UserRoute.php