<?php

Class GeneralSettings extends BaseModel {
	protected $table = 'general_settings';
	protected $fillable = ['idle_timeout','admin_theme','user_theme'];
	public $timestamps = false;
}