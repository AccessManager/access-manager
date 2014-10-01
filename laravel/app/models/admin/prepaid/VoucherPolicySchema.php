<?php

Class VoucherPolicySchema extends BaseModel {

	protected $table = 'voucher_policy_schemas';
	protected $fillable = ['name','mo','tu','we','th','fr','sa','su'];
	public $timestamps = false;	

	public function voucher()
	{
		return $this->morphMany('Voucher', 'policy');
	}

	public function monday()
	{
		return $this->belongsTo('VoucherPolicySchemaTemplate','mo');
	}

	public function tuesday()
	{
		return $this->belongsTo('VoucherPolicySchemaTemplate','tu');
	}

	public function wednesday()
	{
		return $this->belongsTo('VoucherPolicySchemaTemplate','we');
	}

	public function thursday()
	{
		return $this->belongsTo('VoucherPolicySchemaTemplate','th');
	}

	public function friday()
	{
		return $this->belongsTo('VoucherPolicySchemaTemplate','fr');
	}

	public function saturday()
	{
		return $this->belongsTo('VoucherPolicySchemaTemplate','sa');
	}

	public function sunday()
	{
		return $this->belongsTo('VoucherPolicySchemaTemplate','su');
	}
}

//end of file VoucherPolicySchema.php