<?php

class Direcpay extends BaseModel {

	protected $table = 'direcpay_settings';
	protected $fillable = ['status','sandbox','mid','enc_key'];
	public $timestamps = FALSE;
}

//end of file Direcpay.php