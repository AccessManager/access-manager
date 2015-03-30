<?php

class APRecurringProduct extends BaseModel {

	protected $table 		= 'ap_user_recurring_products';
	protected $fillable 	= ['user_id','name','assigned_on','price','taxable','tax_rate','expiry',
								'billing_cycle','billing_unit'];
	public $timestamps 		= FALSE;


	public static function remove( $product_id )
	{
		DB::transaction(function()use($product_id){

			$product = static::findOrFail($product_id);
			if( isValidDate($product->billed_till)){
				$billed_till = new Carbon\Carbon($product->billed_till);
				$today = new Carbon\Carbon;
				if( $billed_till > $today )		return;
			}

			$history = [
				'user_id'		=>	$product->user_id,
				'name'			=>	$product->name,
				'start_date'	=>	isValidDate($product->billed_till) ? $product->billed_till : $product->assigned_on,
				'stop_date'		=>	date('Y-m-d H:i:s'),
				'price'			=>	$product->price,
				'taxable'		=>	$product->taxable,
				'tax_rate'		=>	$product->tax_rate,
				'billed_every'	=>	$product->billing_cycle . $product->billing_unit,
			];
			if( ! APUserRecurringProductHistory::create($history) )
				throw new Exception("Could not add to history");

			if( ! $product->delete() )
				throw new Exception("Could not delete product.");
		});
	}
}
//end of file APProduct.php