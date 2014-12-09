<?php

Class SettingsController extends AdminBaseController {

	public function getGeneral()
	{
		$general = GeneralSettings::first();
		
		
		return View::make('admin.settings.general.general')
						->with('general',$general);
						
	}

	public function postGeneral()
	{
		if( ! Input::has('id') ) {
			return Redirect::route('setting.general')
							->with('error','Required parameter(s) missing.');
		}
		try {
			$input = Input::all();
			$setting = GeneralSettings::find($input['id']);
			$setting->fill( $input );
			$this->flash( $setting->save() );
			return Redirect::route('setting.general');
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function getThemes()
	{
		$themes = Config::get('themes');
		$theme = Theme::first();
		return View::make('admin.settings.general.theme')
						->with('themes',$themes)
						->with('theme',$theme);
	}

	public function postThemes()
	{
		if( ! Input::has('id') ) {
			return Redirect::route('setting.themes.form')
							->with('error','Required parameter(s) missing.');
		}
		try {
			$input = Input::all();
			$setting = Theme::find($input['id']);
			$setting->fill( $input );
			$this->flash( $setting->save() );
			return Redirect::route('setting.themes.form');
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function getEmail()
	{
		$email = EmailSetting::first();
		$tpls = EmailTemplate::lists('name','id');
		return View::make('admin.settings.email.notifications')
					->with('email',$email)
					->with('tpls', $tpls);
	}

	public function postEmail()
	{

	}

	public function getSmtp()
	{
		$smtp = SmtpSettings::first();
		// pr($smtp);
		return View::make('admin.settings.email.smtp')
						->with('smtp',$smtp);
	}

	public function postSmtp()
	{
		if( ! Input::has('id') ) {
			return Redirect::route('setting.smtp')
							->with('error','Required parameter(s) missing.');
		}
		try {
			$input = Input::all();
			$setting = SmtpSettings::find($input['id']);
			$setting->fill( $input );
			$this->flash( $setting->save() );
			return Redirect::route('setting.smtp');
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function getPaypal()
	{
		$currencies = Config::get('paypal_currencies');
		$pp = PaypalSettings::first();
		return View::make('admin.settings.payment_gateway.paypal')
						->with('paypal',$pp)
						->with('currencies',$currencies);
	}

	public function postPaypal()
	{
		if( ! Input::has('id') ) {
			return Redirect::route('setting.paypal')
							->with('error','Required parameter(s) missing.');
		}
		try {
			$input = Input::all();
			$setting = PaypalSettings::find($input['id']);
			$setting->fill( $input );
			$this->flash( $setting->save() );
			return Redirect::route('setting.paypal');
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function getDirecpay()
	{
		$direcpay = Direcpay::first();
		return View::make('admin.settings.payment_gateway.direcpay')
					->with('direcpay', $direcpay);
	}

	public function postDirecpay()
	{
		$input = Input::all();
		$settings = Direcpay::find($input['id']);
		$settings->fill($input);
		if($settings->save()) {
			$this->notifySuccess("Settings Updated.");
		} else {
			$this->notifyError("Settings could not be updated.");
		}
		return Redirect::back();
	}

}