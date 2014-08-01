<?php

Class PolicySchema extends BaseModel {
	protected $table = 'policy_schemas';
	protected $fillable = ['name','mo','tu','we','th','fr','sa','su'];
	public $timestamps = FALSE;

	public function plan()
	{
		return $this->morphMany('Plan','policy');
	}

	public function monday()
	{
		return $this->belongsTo('SchemaTemplate','mo');
	}

	public function tuesday()
	{
		return $this->belongsTo('SchemaTemplate','tu');
	}

	public function wednesday()
	{
		return $this->belongsTo('SchemaTemplate','we');
	}

	public function thursday()
	{
		return $this->belongsTo('SchemaTemplate','th');
	}

	public function friday()
	{
		return $this->belongsTo('SchemaTemplate','fr');
	}

	public function saturday()
	{
		return $this->belongsTo('SchemaTemplate','sa');
	}
	
	public function sunday()
	{
		return $this->belongsTo('SchemaTemplate', 'su');
	}
}