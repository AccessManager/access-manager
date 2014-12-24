<?php
use RAHULMKHJ\PaymentGateways\Direcpay\DirecpayResponse;
class DirecpayTransaction extends BaseModel {

	protected $table = 'direcpay_transactions';
	protected $fillable = ['dp_refrence_id','status','other_details','order_id','amount'];


	public function transaction()
	{
		return $this->morphMany('OnlinePayment','gw');
	}

	public static function initiate( $user_id, Array $other_details )
	{
		return DB::transaction(function()use( $user_id, $other_details ){
			$details = [];
			switch($other_details['type']) {
				case 'recharge':
				$details = [
						'type'	=>		'recharge',
						'plan_id'	=>	$other_details['plan_id'],
						'plan_name'	=>	$other_details['plan_name'],
				];
				break;
				case 'refill':
				$details = [
						'type'		=>	'refill',
						'value'		=>	$other_details['value'],
						'unit'		=>	$other_details['unit'],
				];
			}

			$dp_transaction = new self([
												'status'	=>		'Initiated',
										 'other_details'	=>		http_build_query($details),
										]);
			if( ! $dp_transaction->save() )	throw new Exception('Could not initiate transaction. Failed: Phase 1');

			do{
				$uid = uniqid();
				$exists = OnlinePayment::where('order_id',$uid)->count();
			} while( $exists );

			$payment = [
						'user_id'	=>	$user_id,
						'gw_type'	=>	'DirecpayTransaction',
						  'gw_id'	=>	$dp_transaction->id,
					   'order_id'	=>	$uid,
						 'amount'	=>	$other_details['amount'],
					];

			$transaction = new OnlinePayment($payment);

				if( ! $transaction->save() )	throw new Exception('Could not initiate transaction. Failed: Phase 2');
				return $transaction->order_id;
			});
	}

	public static function updateResponse(DirecpayResponse $dp)
	{
		$response = $dp->getResponse();

		$txn = OnlinePayment::where('order_id',$response['merchantordernumber'])->first();

		$dpTxn = $txn->gw;
		$dpTxn->fill(['status'=>$response['status'],'dp_refrence_id'=>$response['direcpayreferenceid'],]);
		$dpTxn->save();
	}
}
//end of file DirecpayTransaction.php