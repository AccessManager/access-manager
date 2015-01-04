<?php

class Organisation extends BaseModel {

	protected $table = 'organisations';
	protected $fillable = ['name','address','tin'];
	public $timestamps = FALSE;
	
}
//end of file Organsation.php