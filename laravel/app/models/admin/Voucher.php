<?php

Class Voucher extends BaseModel {
	protected $table = 'prepaid_vouchers';
	protected $fillable = ['user_id','pin','method','expires_on','created_at','plan_name',
							'plan_type','limit_id','policy_type','policy_id','sim_sessions',
							'interim_updates','price','validity','validity_unit'];
	
	public function limits()
	{
		return $this->belongsTo('VoucherLimit', 'limit_id');
	}

	public function policy()
	{
		return $this->morphTo();
	}

	public static function index()
	{
		return DB::table('prepaid_vouchers as v')
					->select('v.id','v.pin','v.created_at','v.expires_on','v.plan_name as name','v.method',
							'v.updated_at','u.uname','v.validity','v.validity_unit')
					->leftJoin('user_accounts as u','v.user_id','=','u.id')
					->paginate(10);
	}

	public static function variables($ids)
	{
		return DB::table('prepaid_vouchers as v')
					->select('v.pin','v.expires_on','v.plan_name','v.plan_type','v.sim_sessions','v.price',
							DB::raw('CONCAT(v.validity,v.validity_unit) as voucher_validity'),
							'l.limit_type','l.time_limit','l.time_unit','l.data_limit','l.data_unit',
							'l.aq_access')
					->leftJoin('voucher_limits as l','l.id','=','v.limit_id')
					->whereIn('v.id',$ids)
					->get();
	}

	public static function generate($input)
	{
		$res = [];
		$plan = Plan::findOrFail($input['plan_id']);

			 $voucher['expires_on'] = self::_makeExpiry($input['validity'], $input['validity_unit']);
			 $voucher['created_at'] = time();
			  $voucher['plan_name'] = $plan->name;
			  $voucher['plan_type'] = $plan->plan_type;
		   $voucher['sim_sessions'] = $plan->sim_sessions;
		$voucher['interim_updates'] = $plan->interim_updates;
				  $voucher['price'] = $plan->price;
			   $voucher['validity'] = $plan->validity;
		  $voucher['validity_unit'] = $plan->validity_unit;
		    $voucher['policy_type']	= $plan->policy_type;

		if( $plan->plan_type == 1 ) { //if limited
			$limit = $plan->limit->toArray();

			if( $plan->limit->aq_access == 1 ) {

				// $limit['aq_access'] = 1;
				$aq_policy = Policy::findOrFail($plan->limit->aq_policy);

				$limit['aq_policy'] = mikrotikRateLimit($aq_policy->toArray());
			}
			$voucher_limit = VoucherLimit::create( $limit );

			$voucher['limit_id'] = $voucher_limit->id;
		}

		if( $plan->policy_type == 'Policy') {

			$policy = new VoucherPolicy( ['bw_policy' => mikrotikRateLimit($plan->policy->toArray())] );
			$policy->save();

		} elseif ($plan->policy_type == 'PolicySchema') {

			$days = [
					'mo'	=> 'monday',
					'tu'	=> 'tuesday',
					'we'	=>	'wednesday',
					'th'	=>	'thursday',
					'fr'	=>	'friday',
					'sa'	=>	'saturday',
					'su'	=>	'sunday',
					];

			foreach( $days as $d => $day ) {
				$tpl = $plan->policy->$day->toArray();
				$type = ['bw_policy', 'pr_policy', 'sec_policy'];
				foreach( $type as $t ) {
					if( ! is_null($tpl[$t]) ) {
						$policy = Policy::find($tpl[$t])->toArray();
						$tpl[$t] = mikrotikRateLimit( $policy );
					}
				}
				$template = VoucherPolicySchemaTemplate::create( $tpl );
				$schema[$d] = $template->id;
			}
			$policy = VoucherPolicySchema::create( $schema );
		}
		$voucher['policy_id'] = $policy->id;

		for( $i = 0; $i < $input['count']; $i++ ) {

				   $voucher['pin'] = self::generatePin();
			$voucher['expires_on'] = self::_makeExpiry($input['validity'],$input['validity_unit']);
			
			$v = new Voucher( $voucher );

			if( ! $v->save() ) 		return FALSE;
			$res[] = $v->pin;
		}
		return $res;
	}

	/**
	 * Generates a new unique number to be used as recharge PIN.
	 * Checks uniqueness among existing recharge PINs.
	 * @return integer returns a new unique PIN.
	 */
	private static function generatePin()
	{
		$number = false;

		do {
			$number = mt_rand(1111111,99999999999);
			$exists = self::where('pin','=',$number)->count();
		} while($exists);
		return $number;
	}

	public static function recharge($pin, $account_id)
	{
		$voucher = Recharge::build($pin);
	}

	private static function _makeExpiry($number, $unit)
	{
		$val = Carbon::now();
		$add = "add".$unit;
		$val->$add( $number );
		return $val->toDateString();
	}

}