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
		$admin = Subscriber::findOrFail(Auth::user()->id)->first();

		if( ! Hash::check($input['current'], $admin->pword) ) {
			$this->notifyError("Invalid Current Password.");
			return Redirect::back();
		}
			

		$rules = Config::get('validations.admin_password', NULL);

		$v = Validator::make($input, $rules);
		if($v->fails() )
			return Redirect::back()->withInput()->withErrors($v);

		$admin->pword = Hash::make( $input['password'] );
		$admin->clear_pword = $input['password'];

		if( $admin->save() ) {
			$this->notifySuccess("Admin Password Successfully Updated.");
		} else {
			$this->notifyError("Failed to update admin password, please try again..");
		}
		return Redirect::back();
	}

}

//end of file AdminProfileController.php