<?php

class APInvoiceRecurringProduct extends BaseModel {

	protected $table = 'ap_invoice_recurring_products';

	public function period()
	{
		return date('d M y', strtotime($this->billed_from)) . ' - ' . date('d M y', strtotime($this->billed_till));
	}
	
}
//end of file APInvoiceRecurringProduct.php