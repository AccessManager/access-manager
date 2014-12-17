<?php
use RAHULMKHJ\PaymentGateways\Direcpay\DirecpayResponse;
class DirecpayTransaction extends BaseModel {

	protected $table = 'direcpay_transactions';
	protected $fillable = ['dp_refrence_id','status','other_details','order_id','amount'];


	public function transaction()
	{
		return $this->morphMany('OnlinePayment','gw');
	}

	public static function initiate( $user_id, $amount, Array $other_details )
	{
		return DB::transaction(function()use( $user_id, $amount, $other_details ){

			$dp_transaction = new self([
												'status'	=>		'Initiated',
										 'other_details'	=>		http_build_query($other_details),
										]);
			if( ! $dp_transaction->save() )	throw new Exception('Could not initiate transaction. Failed: Phase 1');

			do{
				$uid = uniqid();
				$exists = OnlinePayment::where('order_id',$uid)->count();
			} while( $exists );
			$transaction = new OnlinePayment([
												'user_id'	=>	$user_id,
												'gw_type'	=>	'DirecpayTransaction',
												  'gw_id'	=>	$dp_transaction->id,
											   'order_id'	=>	$uid,
												 'amount'	=>	$amount
											]);
				if( ! $transaction->save() )	throw new Exception('Could not initiate transaction. Failed: Phase 2');
				
				return $transaction->order_id;
			});
	}

	public static function succeed(DirecpayResponse $dp)
	{
		$response = $dp->getResponse();

		$txn = OnlinePayment::where('order_id',$response['merchantordernumber'])->first();

		$dpTxn = $txn->gw;
		$dpTxn->fill(['status'=>$response['status'],'dp_refrence_id'=>$response['direcpayreferenceid'],]);
		$dpTxn->save();
	}
}
//end of file DirecpayTransaction.php