<?php

Class Router extends BaseModel {
	protected $table = 'nas';
	protected $fillable = ['nasname','shortname','ports','secret','description'];
	public $timestamps = false;
}