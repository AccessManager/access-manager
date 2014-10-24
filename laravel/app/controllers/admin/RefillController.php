<?php
use Carbon\Carbon;
class RefillController extends AdminBaseController {

	const HOME = 'refill.index';

	public function getIndex()
	{
		return View::make('admin.refill_coupons.index')
					->with('vouchers',Refillcoupons::paginate(10));
	}

	public function getGenerate()
	{
		return View::make('admin.refill_coupons.generate');
	}

	public function postGenerate()
	{
		$count = Input::get('count', NULL);
		$input = Input::except('count');
		
		$input['expires_on'] = $this->_makeExpiry($input['validity'], $input['validity_unit']);

		for( $i = 0; $i < $count; $i++ ) {
			$input['pin'] = $this->_generatePin();
			if ( ! Refillcoupons::create($input) ) {
				$this->notifyError('Failed to generate one or more vouchers.');
				return Redirect::route(self::HOME);
			}
		}
		$this->notifySuccess("Successfully generated $count Voucher(s).");
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
			Refillcoupons::viaPin(Input::get('pin'), Input::get('user_id'));
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