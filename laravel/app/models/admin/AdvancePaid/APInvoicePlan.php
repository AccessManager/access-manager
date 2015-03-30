<?php

class APInvoicePlan extends BaseModel {

	protected $table = 'ap_invoice_plans';
	protected $fillable = [];
	public $timestamps = FALSE;

	// public function invoice()
	// {
	// 	return $this->belongsTo('APInvoice','invoice_id');
	// }
	public function period()
	{
		// var_dump($this->billed_from); exit;
		return date('d M y', strtotime($this->billed_from)) . ' - ' . date('d M y', strtotime($this->billed_till));
	}

}
//end of file APInvoicePlan.php