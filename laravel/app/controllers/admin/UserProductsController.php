<?php

class UserProductsController extends AdminBaseController {


	public function postAddRecurringProduct()
	{
		$product = new APRecurringProduct;

		$input = Input::all();
		$input['assigned_on']	= 	date('Y-m-d H:i:s');
		$product->fill($input);
		if( $product->save()) {
			$this->notifySuccess("Product Added.");
		} else {
			$this->notifyError("Product Could not be added.");
		}
		return Redirect::back();
	}

	public function postEditRecurringProduct()
	{
		$id = Input::get('id');
		$product = APRecurringProduct::find($id);
		$product->fill(Input::all());

		if( $product->save()) {
			$this->notifySuccess('Product Updated.');
		} else {
			$this->notifyError('Product could not be updated.');
		}
		return Redirect::back();
	}

	public function postDeleteRecurringProduct()
	{
		try {
			$id = Input::get('id', 0);
			APRecurringProduct::remove($id);
			$this->notifySuccess('Product Deleted.');
		}
		catch(Exception $e) {
			$this->notifyError($e->getMessage());
		}
		finally {
			return Redirect::back();
		}
	}

	public function postAddNonRecurringProduct()
	{
		$input = Input::all();
		$input['assigned_on'] = date('Y-m-d H:i:s');
		if( APNonRecurringProduct::create($input) ) {
			$this->notifySuccess('Product Added.');
		} else {
			$this->notifyError("Product could not be added.");
		}
		return Redirect::back();
	}

	public function postEditNonRecurringProduct()
	{
		$id = Input::get('id', 0);
		// pr(Input::all());
		$product = APNonRecurringProduct::find($id);

		$product->fill(Input::all());

		if($product->save()) {
			$this->notifySuccess("Product Updated.");
		} else {
			$this->notifyError("Product could not be updated.");
		}
		return Redirect::back();
	}

	public function postDeleteNonRecurringProduct()
	{
		$id = Input::get('id', 0);

		if( APNonRecurringProduct::destroy($id) ) {
			$this->notifySuccess("Product Deleted.");
		} else {
			$this->notifyError("Product could not be deleted.");
		}
		return Redirect::back();
	}
}
//end of file ProductsControlle.php