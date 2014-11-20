<?php

Class GeneralSettings extends BaseModel {
	protected $table = 'general_settings';
	protected $fillable = ['idle_timeout','self_signup','allow_free_ppp'];
	public $timestamps = false;
}