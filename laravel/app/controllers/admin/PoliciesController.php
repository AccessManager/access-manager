<?php

Class PoliciesController extends AdminBaseController {
	
	const HOME = 'policies.index';

	public function getIndex()
	{
		$policies = Policy::paginate(10);
		return View::make('admin.policies.index',['policies'=>$policies]);
	}

	public function getAdd()
	{
		return View::make('admin.policies.add-edit');
	}

	public function postAdd()
	{
		$input = Input::all();	//pr($input);
		$rules = Config::get('validations.policies');
		
		$v = Validator::make($input, $rules);
		$v->setAttributeNames(Config::get('attributes.policies'));
		if($v->fails() )
			return Redirect::back()
							->withErrors($v)
								->withInput();
		try {
			if( ! Policy::create($input) )	throw new Exception("Failed to create policy: {$input['name']}");
			$this->notifySuccess("Successfully created bandwidth policy: <b>{$input['name']}</b>");
		}
		catch(Exception $e) {
			$this->notifyError($e->getMessage());
			return Redirect::route(self::HOME);
		}
		return Redirect::route(self::HOME);
	}

	public function getEdit($id)
	{
		try{
			$policy = Policy::findOrFail($id);
			return View::make('admin.policies.add-edit')->with('policy', $policy);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postEdit()
	{
		$input = Input::all();
		$rules = Config::get('validations.policies');
		
		$v = Validator::make($input, $rules);
		$v->setAttributeNames(Config::get('attributes.policies'));
		
		if($v->fails() )
			return Redirect::back()
							->withErrors($v)
								->withInput();
		try{
			if( ! $policy = Policy::find($input['id']) ) throw new Exception("No such policy.");
			$policy->fill($input);
			if( ! $policy->save() ) throw new Exception("Failed to save bandwidth policy: {$input['name']}");
			
			$this->notifySuccess("Successfully updated Bandwidth Policy: <b>{$input['name']}</b>");
		}
		catch(Exception $e) {
			$this->notifyError($e->getMessage());
			return Redirect::route(self::HOME);
		}
		return Redirect::route(self::HOME);
	}

	public function postDelete($id)
	{
		try {
			if( ! Policy::Destroy($id) )	throw new Exception("Bandwidth Policy deletion failed.");
			$this->notifySuccess("Bandwidth Policy successfully deleted.");
		}
		catch(Exception $e) {
			$this->notifyError($e->getMessage());
			return Redirect::route('policies.index');
		}
		return Redirect::route('policies.index');
	}

}