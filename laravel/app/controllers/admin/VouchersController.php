<?php

Class VouchersController extends AdminBaseController {

	const HOME = 'voucher.index';

	public function getIndex()
	{
		$vouchers = Voucher::index();
		return View::make('admin.vouchers.index')
						->with('vouchers',$vouchers);
	}

	public function getGenerate()
	{
		$plans = Plan::lists('name','id');
			return View::make('admin.vouchers.generate')
							->with('plans',$plans);
	}

	public function postGenerate()
	{
		$input = Input::all();
		//validate input
		$rules = Config::get('validations.generate_vouchers');
		$v = Validator::make($input, $rules);
		$v->setAttributeNames(Config::get('attributes.generate_vouchers'));
		if( $v->fails() )
			return Redirect::back()
							->withInput()
							->withErrors($v);
		try{
			DB::transaction(function() use($input) {
				if( ! Voucher::generate($input) ) throw new Exception("Failed to generate vouchers.");
			});
			$this->notifySuccess("Generated {$input['count']} vouchers valid for {$input['validity']} {$input['validity_unit']}.");
			return Redirect::route(self::HOME);
		}
		catch(Exception $e) {
			$this->notifyError($e->getMessage());
			return Redirect::route(self::HOME);
		}
	}

	public function getRecharge()
	{
		$accounts = Subscriber::where('is_admin',0)
								->where('plan_type', PREPAID_PLAN)
								->lists('uname','id');
		return View::make('admin.vouchers.recharge')
						->with('plans', Plan::lists('name','id'))
						->with('accounts', $accounts);
	}

	public function postRecharge()
	{
		$input = Input::all();

		$v = Validator::make(
								$input,
								Config::get('validations.recharge_account')
							);
		$v->setAttributeNames(Config::get('attributes.recharge_account'));

		if( $v->fails() )
			return Redirect::back()	->withInput()	->withErrors($v);

		Recharge::viaAdmin($input);
		return Redirect::route(self::HOME);
	}


	public function postSelectTemplate()
	{
		if( Input::has('print') )
			return $this->selectTemplate( Input::all() );
		if(Input::has('destroy'))
			return $this->destroy( Input::all() );
	}

	public function postPrint()
	{
		Session::reflash();
		$result = NULL;
		$tpl_id = Input::get('template', 0);
		$count = Input::get('count', 1);
		$type = Input::get('type');
		$voucher_ids = Session::get('vouchers',['0']);
		$parser = new TemplateParser;

		$template = VoucherTemplate::find($tpl_id);

		switch( $type ) {
			case 'prepaid_voucher' :
			$vouchers = Voucher::variables($voucher_ids);	
			break;
			case 'refill_coupon' :
			$vouchers = refillcoupons::variables($voucher_ids);
			break;
			default:
			throw new Exception("Could not determine form type. Could not proceed.");
			break;
		}
		
		$i = 1;
		foreach($vouchers as $voucher) {
			$parser->initData((array)$voucher);
			$result .= $parser->parseTemplateData($template->body);
			
			if( ($i % $count) == 0 ) {
				$result .= "<br />";
			} else {
				$result .= "&nbsp;";
			}
			$i++;
		}
		if($i > 1) {
			$result .= "<br />" . Form::button('Print This Page', ['onclick'=>'window.print()','class'=>'btn btn-primary col-lg-offset-1']);
		} else {
			$result = "Please select atleast one voucher";
		}
		
		return View::make('admin.vouchers.print')
						->with('vouchers',$result);
	}

	public function destroy($input)
	{
		echo "Reached destroy function";
	}

	private function selectTemplate($input)
	{
		Session::flash('vouchers',$input['vouchers']);
		$tpls = VoucherTemplate::lists('name','id');
		return View::make('admin.vouchers.selectTemplate')
					->with('templates',$tpls);
	}
}