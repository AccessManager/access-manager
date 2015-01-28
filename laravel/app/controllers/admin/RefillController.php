<?php
use Carbon\Carbon;
class RefillController extends AdminBaseController {

	const HOME = 'refill.index';

	public function getIndex()
	{
		return View::make('admin.refill_coupons.index')
					->with('vouchers',Refillcoupons::getAll());
	}

	public function getGenerate()
	{
		return View::make('admin.refill_coupons.generate');
	}

	public function postGenerate()
	{
		if( $pins = Refillcoupons::generate( Input::all() ) ) {
			$count = count($pins);
			$this->notifySuccess("Generated $count Voucher(s).");
		} else {
			$this->notifyError("Voucher Generation Failed.");
		}
		return Redirect::route(self::HOME);
	}

	public function getRecharge()
	{
		$accounts = Subscriber::where('is_admin',0)
						->where(function($query){
							$query->where('plan_type', PREPAID_PLAN)
							->orWhere('plan_type',FREE_PLAN);
						})
						->orderby('uname')
						->lists('uname','id');
		return View::make('admin.refill_coupons.recharge')
						->with('accounts', $accounts);
	}

	public function postRecharge()
	{
		try {
			if( Refillcoupons::viaPin(Input::get('pin'), Input::get('user_id')) ) {
				$this->notifySuccess('Refill Successful.');
			} else {
				$this->notifyError('Refill Failed.');
			}
		}
		catch(Exception $e) {
			$this->notifyError($e->getMessage());
			return Redirect::back();
		}
			return Redirect::back();
	}

	private static function _generatePin()
	{
		$number = false;
		do {
			$number = mt_rand(1111111,99999999999);
			$exists = Voucher::where('pin','=',$number)->count();
		} while($exists);
		return $number;
	}

	private static function _makeExpiry($number, $unit)
	{
		$val = Carbon::now();
		$add = "add".$unit;
		$val->$add( $number );
		return $val->toDateTimeString();
	}

}