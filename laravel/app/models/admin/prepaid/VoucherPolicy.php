<?php

class VoucherPolicy extends BaseModel {

	protected $table = 'voucher_bw_policies';

	protected $fillable = ['bw_policy'];
	public $timestamps = FALSE;

	public function voucher()
	{
		return $this->morphMany('Voucher', 'policy');
	}
}