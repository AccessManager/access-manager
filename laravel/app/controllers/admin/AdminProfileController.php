<?php

Class AdminProfileController extends AdminBaseController {

	public function getEdit()
	{
		$profile = Subscriber::find(Auth::user()->id);
		return View::make('admin.my_profile.edit')
						->with('profile',$profile);
	}

	public function postEdit()
	{
		if( ! Input::has('id'))		return Redirect::back()->withInput();

		$input = Input::all();
		//validate input

		try{
			$profile = Subscriber::findOrFail($input['id']);
			$profile->fill( $input);
			$this->flash( $profile->save() );
			return Redirect::route('admin.profile.edit');
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}

	}

	public function getChangePassword()
	{
		return View::make('admin.my_profile.change_password');
	}

	public function postChangePassword()
	{
		$input = Input::all();

		pr($input);
	}
}