<?php

class APInvoice extends BaseModel {

	protected $table 						= 'ap_invoices';
	protected $fillable 					= [];
	public $timestamps 						= FALSE;

	private $lastInvoice 					= NULL;
	private $plansAmount 					= 0;
	private $plansTax 						= 0;
	private $recurringProductsAmount 		= 0;
	private $recurringProductsTax 			= 0;
	private $nonRecurringProductsAmount 	= 0;
	private $nonRecurringProductsTax 		= 0;
	private $latePaymentCharges 			= 0;

	public function account()
	{
		return $this->belongsTo('Subscriber','user_id');
	}

	public function plans()
	{
		return $this->hasMany('APInvoicePlan','invoice_id');
	}

	public function recurringProducts()
	{
		return $this->hasMany('APInvoiceRecurringProduct','invoice_id');
	}

	public function nonRecurringProducts()
	{
		return $this->hasMany('APInvoiceNonRecurringProduct','invoice_id');
	}

	public function billPeriod()
	{
		$startDate = date('d M y', strtotime($this->bill_period_start));
		$stopDate = date('d M y', strtotime($this->bill_period_stop));

		return $startDate . ' - ' . $stopDate;
	}

	public function dueDate()
	{
		$settings = APSetting::first();

		$generated_on = new Carbon($this->generated_on);

		$generated_on->addDays($settings->payment_due_in_days);

		return $generated_on->format('d M y');
	}

	private function _fetchLastInvoice()
	{
		if( $this->lastInvoice == NULL )
			$this->lastInvoice = static::where('user_id', $this->account->id)
								->where('id','<', $this->id)
								->orderby('id','DESC')
								->select('generated_on')
								->first();
		// $log = DB::getQueryLog();
		// $query = end($log);
		// pr($query);

	}

	public function previousBalance()
	{
		return $this->prev_adjustments?: 0;
	}

	public function latestPayments()
	{
		$this->_fetchLastInvoice();

		$q = APTransaction::where('type','cr')
							->where('user_id', $this->account->id)
							->where('created_at','<', $this->generated_on)
							->select(DB::raw('sum(amount) as amount'));

		if( $this->lastInvoice != NULL )
			$q->where('created_at','>',$this->lastInvoice->generated_on);

		$payment = $q->first();
		return $payment->amount ?: 0;
	}

	public function balance()
	{
		return $this->previousBalance() - $this->latestPayments() 
		// - $this->discount()
		;
	}

	public function thisMonthsCharges()
	{
		return 
		// $this->balance()
		// 				+ 
						$this->plansAmount() 
						+ $this->plansTax() 
					 	+ $this->recurringProductsAmount() 
					 	+ $this->recurringProductsTax()
					 	+ $this->nonRecurringProductsAmount()
					 	+ $this->nonRecurringProductsTax()
					 	// - $this->discount()
					 	;
	}



	public function activeServicePlan()
	{
		$plan = APActivePlan::where('user_id', $this->account->id)
							->first();
		return $plan->plan_name;
	}

	public function amountPayableByDueDate()
	{
		
		return $this->thisMonthsCharges() + $this->balance() + $this->discount();
	}

	public function amountPayableAfterDueDate()
	{
		return $this->amountPayableByDueDate() + $this->latePaymentCharges();
	}

	public function plansAmount()
	{
		$plans = DB::table('ap_invoice_plans')
					->where('invoice_id', $this->id)
					->select(DB::raw('sum(amount) as amount'))
					->first();

		return  round($plans->amount, 2);
	}

	public function plansTax()
	{
		$plans = DB::table('ap_invoice_plans')
					->where('invoice_id', $this->id)
					->select(DB::raw('sum(tax) as tax'))
					->first();

		return  round($plans->tax, 2);
	}

	public function recurringProductsAmount()
	{
		$recurringProdcuts = DB::table('ap_invoice_recurring_products')
								->where('invoice_id', $this->id)
								->select(DB::raw('sum(amount) as amount'))
								->first();

		return round($recurringProdcuts->amount, 2);
	}

	public function recurringProductsTax()
	{
		$recurringProdcuts = DB::table('ap_invoice_recurring_products')
								->where('invoice_id', $this->id)
								->select(DB::raw('sum(tax) as tax'))
								->first();
		return round($recurringProdcuts->tax, 2);
	}

	public function nonRecurringProductsAmount()
	{
		$products = DB::table('ap_invoice_non_recurring_products')
								->where('invoice_id', $this->id)
								->select(DB::raw('sum(amount) as amount'))
								->first();
		return round($products->amount, 2);
	}

	public function nonRecurringProductsTax()
	{
		$products = DB::table('ap_invoice_non_recurring_products')
								->where('invoice_id', $this->id)
								->select(DB::raw('sum(tax) as tax'))
								->first();

		return round($products->tax, 2);
	}

	public function latePaymentCharges()
	{
		$settings = APSetting::first();
		if( $settings->due_amount_penalty_status ) {
			$totalAmount 		= $this->plansAmount() + $this->recurringProductsAmount() + $this->nonRecurringProductsAmount();
			$calculatedPenalty 	= $totalAmount * $settings->due_amount_penalty_percent / 100;
			$finalPenalty 		= $calculatedPenalty > $settings->due_amount_penalty_minimum ? $calculatedPenalty : $settings->due_amount_penalty_minimum;
			return round($finalPenalty, 2);
		}
		return 0;
	}

	public function discount()
	{
		$q = DB::table('ap_invoice_plans as p')
				->where('invoice_id', $this->id)
				->select(DB::raw('sum(adjustment) as adjustment'))
				->first();

		return 0 - round($q->adjustment, 2);
	}

	public static function findByNumber( $invoiceNumber )
	{
		return static::where('invoice_number', $invoiceNumber)->first();
	}

	// public function __construct($attributes = [])
	// {
	// 	parent::__construct($attributes);

	// }

}
//end of file APInvoice.php