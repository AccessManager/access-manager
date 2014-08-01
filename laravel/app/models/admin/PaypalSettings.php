<?php

Class PaypalSettings extends BaseModel {
	protected $table = 'paypal_settings';
	protected $fillable = ['status','email','currency','sandbox'];
	public $timestamps = false;
}