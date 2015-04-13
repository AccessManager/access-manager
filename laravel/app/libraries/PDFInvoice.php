<?php
use \fpdf\FPDF;

class PDFInvoice extends FPDF {

	private $invoice;
	// private $pdf;

	public function Header()
	{
		$this->Image(public_path('public/img/esto-logo-invoice.png'));
		$this->SetFont('Arial','B',25);
		$this->SetXY(85,27);
		$this->Cell(130,0,'Tax Invoice',0,5,'C');
		$this->Ln(20);
		$this->SetFont('Arial','B',15);
		$this->Cell(80);
		$this->Ln(5);
	}

	public function Footer()
	{
		$this->SetXY(10,275);
		$this->SetFont('Arial','',8);
		$this->Ln();
		$this->Cell(185,0,'Esto Internet Private Limited, 435/1 Sector 45A CHANDIGARH',0,5,'C');
		$this->Ln(4);
		$this->Cell(185,0,'phone: 01795-650850 | email: askus@estointernet.com | web: estointernet.in',0,5,'C');
		$this->Ln(4);
		$this->Cell(185,0,'Service Tax Number: AAHCA6346FSD002',0,5,'C');
		$this->SetXY(10,270);
		$this->SetFont('Times','I',8);
		$this->Cell(85,0,'This is a computer generated invoice, thus requires no signature.',0,5,'L');
	}

	public function render()
	{
		$this->_makeInvoice();
		return $this->output();
	}

	private function _makeInvoice()
	{
		$this->_clientName();
		$this->_clientAddress();
		$this->_clientAccountDetails();
		$this->_accountSummary();
		$this->_currentServicePlan();
		$this->_thisMonthCharges();
		$this->_bankDetails();
	}

	private function _clientName()
	{
		$this->SetFont('Times','B',14);
		$this->SetXY(10,40);
		$this->Cell(50,5, $this->invoice->account->fname . ' ' . $this->invoice->account->lname);
		$this->Ln();
	}

	private function _clientAddress()
	{
		$this->SetFont('Times','',11);

		$this->MultiCell(85,5, $this->invoice->account->address);
		$this->Cell(50,5, $this->invoice->account->contact);
	}

	private function _clientAccountDetails()
	{
		$this->SetFont('Times', 'B', 11);
		$this->SetXY(125, 40);
		$this->Cell(30,5,'Account ID');
		$this->SetFont('Times','', 11);
		$this->Cell(50,5,": {$this->invoice->account->uname}");
		$this->Ln();
		$this->SetFont('Times', 'B', 11);
		$this->SetXY(125, 45);
		$this->Cell(30,5,'Bill Number');
		$this->SetFont('Times', '', 11);
		$this->Cell(50,5,": {$this->invoice->invoice_number}");
		$this->SetFont('Times', 'B', 11);
		$this->SetXY(125, 50);
		$this->Cell(30,5,'Bill Date');
		$this->SetFont('Times', '', 11);
		$this->Cell(50,5,': ' . date('d M y', strtotime($this->invoice->generated_on)));
		$this->SetFont('Times', 'B', 11);
		$this->SetXY(125, 55);
		$this->Cell(30,5,'Bill Period');
		$this->SetFont('Times', '', 11);
		$this->Cell(50,5,': ' . $this->invoice->billPeriod());
		$this->SetFont('Times', 'B', 11);
		$this->SetXY(125, 60);
		$this->Cell(30,5,'Due Date');
		$this->Cell(50,5,': ' . $this->invoice->dueDate());
	}

	private function _accountSummary()
	{
		$this->SetXY(10,75);
		$this->SetFont('Times','B',13);
		$this->Cell(70,0,'Account Summary');
		$this->Ln();
		$this->Cell(150,5,'-------------------------------------------------------------------------------------'
							.'--------------------------------------');
		$this->Ln();
		$this->SetFont('Times','B',10);
		$this->MultiCell(20.7,4,'Previous Balance',0,'C');
		$this->SetXY(37,80);
		$this->Cell(18.7,4,'Payments',0,0,'C');
		$this->Cell(32,4,'Balance',0,0,'C');
		$this->MultiCell(26.7,4,"This Month's charges",0,'C');
		$this->SetXY(115,80);
		$this->Cell(23,4,'Adjustment',0,0,'C');
		
		// $this->Cell(4,5,'',0,0,'C');
		
		
		$this->MultiCell(29,5,'Payable by Due Date',0,'C');
		$this->SetXY(172,80);
		$this->MultiCell(23.7,5,'Payable after Due Date',0,'C');
		$this->Ln(1);
		$this->Cell(23.7,10,$this->invoice->previousBalance(),1,0,'C');
		$this->Cell(3,8,'-',0,0,'C');
		$this->Cell(23.7,10, $this->invoice->latestPayments(),1,0,'C');
		$this->Cell(3,8,'=',0,0,'C');
		$this->Cell(23.7,10, $this->invoice->balance(),1,0,'C');
		$this->Cell(3,8,'+',0,0,'C');
		$this->Cell(23.7,10,$this->invoice->thisMonthsCharges(),1,0,'C');
		$this->Cell(3,8,'+',0,0,'C');
		$this->Cell(23.7,10, $this->invoice->discount(),1,0,'C');
		$this->Cell(3,8,'=',0,0,'C');
		$this->Cell(23.7,10,$this->invoice->amountPayableByDueDate(),1,0,'C');
		$this->Cell(3,8,'',0,0,'C');
		$this->Cell(23.7,10, $this->invoice->amountPayableAfterDueDate(),1,0,'C');
	}

	private function _currentServicePlan()
	{
		$this->Ln(15);
		$this->SetFont('Times','B',11);
		$this->Cell(100,7,"Active Service Plan: " . $this->invoice->activeServicePlan(),1,0,'L');
	}

	private function _thisMonthCharges()
	{
		$this->Ln(10);
		$this->Cell(150,8,"This Month's Charges");
		$this->Ln();
		$this->Cell(108,140,'','TLRB',0,'L');
		$this->Ln(1);
		$this->SetFont('Times','',9);
		$this->Cell(107,5,'Amount in INR',0,0,'R');
		$this->Ln(4);
		
		
		$this->_broadbandTotalCharges();
		$this->_totalDiscounts();
		$this->_broadbandTotalTax();
		
		$this->_broadbandCharges();

		if( count($this->invoice->recurringProducts) ) {
			$this->_recurringProductsTotalCharges();
			$this->_recurringProductsTotalTaxes();
			$this->_recurringProductsCharges();
		}

		if( count($this->invoice->nonRecurringProducts) ) {
			$this->_nonRecurringProductsTotalCharges();
			$this->_nonRecurringProductTotalTax();
			$this->_nonRecurringProductsCharges();
		}
		
		// $this->SetXY(98,140);
		$this->_total();
	}

	private function _bankDetails()
	{
		$this->SetXY(130,123);
		$this->SetFont('Arial','B',9);
		$this->Cell(90,5,'Kindly make payment in favor of:');
		$this->SetFont('Arial','',9);
		$this->SetXY(130,128);
		$this->Cell(90,5,"Esto Internet Private Limited");
		$this->SetXY(130,133);
		$this->SetFont('Arial','B',9);
		$this->Cell(90,5,"Bank Details:");

		$this->SetXY(129,132);
		$this->SetFont('Arial','',9);
		$this->MultiCell(90,5," \n Bank Name: ICICI Bank \n Account No. 658905500086 \n IFSC: ICIC0006589 \n Branch: Sai Road, Baddi");
	}

	private function _broadbandTotalCharges()
	{
		$this->SetFont('Times','B',10);
		$this->Cell(90,3.8,'Total Broadband Charges',0,0,'L');
		$this->Cell(14,8,$this->invoice->plansAmount(),'',0,'R');
		$this->Ln(4);
	}

	private function _broadbandCharges()
	{
		foreach( $this->invoice->plans as $plan ):
			$this->SetFont('Times','',9.5);
			$this->Cell(90,6,"{$plan->plan_name} @ {$plan->rate}/Month",0,0,'L');
			$this->Ln(4);
			$this->SetFont('Times','',8);
			$this->Cell(75,6,$plan->period(),0,0,'L');
			$this->Cell(10,5,$plan->amount,0,0,'R');
			$this->Ln(4);
			if( $plan->adjustment != 0.00 ):
				$this->Cell(75,6,"Discount/Adjustment");
				$this->Cell(10,6,(0 - $plan->adjustment),0,0,'R');
				$this->Ln(4);
			endif;
			$this->Cell(65,6,"Service Tax @ $plan->tax_rate");
			$this->Cell(10,6,$plan->tax,0,0,'R');
			$this->Ln();
		endforeach;
	}

	private function _broadbandTotalTax()
	{
		
		$this->SetFont('Times','B',10);
		$this->Cell(90,3.8,'Service Tax',0,0,'L');
		$this->Cell(14,8, $this->invoice->plansTax(),'',0,'R');
		$this->Ln(5);
	}

	private function _totalDiscounts()
	{
		$discount = $this->invoice->discount();
		if( $discount != 0.00 || $discount != 0 ):
			$this->SetFont('Times','B',10);
			$this->Cell(90,3.8,'Discounts/Adjustments',0,0,'L');
			$this->Cell(14,8,$discount,'',0,'R');
			$this->Ln(4);
		endif;
	}

	private function _recurringProductsTotalCharges()
	{
		$this->SetFont('Times','B',10);
		$this->Cell(90,3.8,'Additional Recurring Services',0,0,'L');
		$this->Cell(14,8, $this->invoice->recurringProductsAmount(),'',0,'R');
		$this->Ln(4);
	}


	private function _recurringProductsTotalTaxes()
	{
		$this->SetFont('Times','B',10);
		$this->Cell(90,3.8,'Service Tax',0,0,'L');
		$this->Cell(14,8,$this->invoice->recurringProductsTax(),'',0,'R');
		$this->Ln(4);
	}

	private function _recurringProductsCharges()
	{
		foreach( $this->invoice->recurringProducts as $product ):
			$this->SetFont('Times','',9.5);
			$this->Cell(90,6,"{$product->name} @ {$product->rate}/Month",0,0,'L');
			$this->Ln(4);
			$this->SetFont('Times','',8);
			$this->Cell(75,6,$product->period(),0,0,'L');
			$this->Cell(10,5,$product->amount,0,0,'R');
			$this->Ln(4);
			$this->Cell(65,6,"Service Tax @ {$product->tax_rate}");
			$this->Cell(10,6,$product->tax,0,0,'R');
			$this->Ln();
		endforeach;
	}
	private function _nonRecurringProductsTotalCharges()
	{
		$this->SetFont('Times','B',10);
		$this->Cell(100,3.8,'Additional Charges',0,0,'L');
		$this->Cell(14,8,$this->invoice->nonRecurringProductsAmount(),0,'R');
		$this->Ln(4);
	}


	private function _nonRecurringProductTotalTax()
	{
		$this->SetFont('Times','B',10);
		$this->Cell(90,3.8,'Service Tax','L',0,'L');
		$this->Cell(14,8, $this->invoice->nonRecurringProductsTax(),'',0,'R');
		$this->Ln(4);
	}

	private function _nonRecurringProductsCharges()
	{
		foreach( $this->invoice->nonRecurringProducts as $product ):
			$this->SetFont('Times','',9);
			$this->Cell(75,6,$product->name,0,0,'L');
			$this->Cell(10,6,$product->amount,0,0,'R');
			$this->Ln();
			if( $product->tax != 0 || $product->tax != 0.00 ):
				$this->Cell(65,6,"Service Tax @ {$product->tax_rate}");
				$this->Cell(10,8,$product->tax,0,0,'R');
				$this->Ln();
			endif;
		endforeach;
	}

	private function _total()
	{
		$this->Ln(4);
		$this->SetFont('Times','B',10);
		$this->Cell(90,3.8,'Total',0,0,'L');
		$this->Cell(108,8, $this->invoice->thisMonthsCharges() + $this->invoice->discount());
	}

	public function __construct( $invoice )
	{
		parent::__construct('P','mm','A4');
		$this->addPage();
		$this->SetAutoPageBreak(TRUE, 30);
		$this->invoice = $invoice;
	}
}
//end of file PDFInvoice.php