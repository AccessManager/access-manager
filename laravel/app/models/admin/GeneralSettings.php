<?php

Class GeneralSettings extends BaseModel {
	protected $table = 'general_settings';
	protected $fillable = ['idle_timeout',];
	public $timestamps = false;
}