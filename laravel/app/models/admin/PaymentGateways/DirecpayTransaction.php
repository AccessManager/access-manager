<?php

class DirecpayTransaction extends BaseModel {

	protected $table = 'direcpay_transactions';
	protected $fillable = ['dp_refrence_id','status','other_details','order_id','amount'];


	public function transaction()
	{
		return $this->morphMany('OnlinePayment','gw');
	}
}
//end of file DirecpayTransaction.php