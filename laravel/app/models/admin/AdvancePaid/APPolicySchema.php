<?php

class APPolicySchema extends BaseModel {

	protected $table = 'ap_policy_schemas';
	protected $fillable = ['name','mo','tu','we','th','fr','sa','su'];
	public $timestamps = FALSE;

	public function plan()
	{
		return $this->morphMany('APActivePlan','policy');
	}

	public function monday()
	{
		return $this->belongsTo('APPolicySchemaTemplate','mo');
	}

	public function tuesday()
	{
		return $this->belongsTo('APPolicySchemaTemplate','tu');
	}

	public function wednesday()
	{
		return $this->belongsTo('APPolicySchemaTemplate','we');
	}

	public function thursday()
	{
		return $this->belongsTo('APPolicySchemaTemplate','th');
	}

	public function friday()
	{
		return $this->belongsTo('APPolicySchemaTemplate','fr');
	}

	public function saturday()
	{
		return $this->belongsTo('APPolicySchemaTemplate','sa');
	}

	public function sunday()
	{
		return $this->belongsTo('APPolicySchemaTemplate','su');
	}
}

//end of file APPolicySchema.php