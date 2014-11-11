<?php

Class TemplatesController extends AdminBaseController {

	const VoucherHome = 'tpl.voucher.index';
	const EmailHome = 'tpl.email.index';

	public function getVoucherTemplates()
	{
		$tpls = VoucherTemplate::paginate(10);
		return View::make('admin.templates.vouchers.index')
							->with('templates',$tpls);
	}

	public function getAddVoucherTemplate()	
	{
		return View::make('admin.templates/vouchers/add-edit');
	}

	public function postAddVoucherTemplate()
	{
		$input = Input::all();

		//validation input here.

		if( VoucherTemplate::create($input) ) {
			$this->notifySuccess("Voucher Template Created.");
		} else {
			$this->notifyError("Voucher Template Creation Failed.");
		}
		return Redirect::route(self::VoucherHome);
	}

	public function getEditVoucherTemplate($id)
	{
		try{
			$tpl = VoucherTemplate::findOrFail($id);
			return View::make('admin.templates/vouchers/add-edit')
						->with('template',$tpl);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postEditVoucherTemplate()
	{
		if( ! Input::has('id')) {
			return Redirect::route(self::VoucherHome);
		}
		$input = Input::all();
		try{
			$tpl = VoucherTemplate::findOrFail($input['id']);
			$tpl->fill( $input );
			if( $tpl->save() ) {
				$this->notifySuccess("Voucher Template Updated.");
			} else {
				$this->notifyError("Voucher Template Updation Failed.");
			}
			return Redirect::route(self::VoucherHome);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postDeleteVoucherTemplate($id)
	{
		$this->flash( VoucherTemplate::destroy($id) );
		return Redirect::route(self::VoucherHome);
	}

	public function getEmailTemplates()
	{
		$tpls = EmailTemplate::paginate(10);
		return View::make('admin.templates.email.index')
						->with('templates',$tpls);
	}

	public function getAddEmailTemplate()
	{
		return View::make('admin.templates.email.add-edit');
	}

	public function postAddEmailTemplate()
	{
		$input = Input::all();
		//validate input.
		$this->flash( EmailTemplate::create($input) );
		return Redirect::route(self::EmailHome);
	}

	public function getEditEmailTemplate($id)
	{
		try{
			$tpl = EmailTemplate::findOrFail($id);
			return View::make('admin.templates/email/add-edit')
						->with('template',$tpl);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postEditEmailTemplate()
	{
		if( ! Input::has('id')) {
			return Redirect::route(self::EmailHome);
		}
		$input = Input::all();
		try{
			$tpl = EmailTemplate::findOrFail($input['id']);
			$tpl->fill( $input );
			$this->flash( $tpl->save() );
			return Redirect::route(self::EmailHome);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postDeleteEmailTemplate($id)
	{
		$this->flash( EmailTemplate::destroy($id) );
		return Redirect::route(self::EmailHome);
	}

}