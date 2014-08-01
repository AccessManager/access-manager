<?php

Class RoutersController extends AdminBaseController {

	const HOME = 'router.index';

	public function getIndex()
	{
				$routers = Router::paginate(10);
			return View::make('admin.routers.index')
							->with('routers',$routers);
	}

	public function getAdd()
	{
		return View::make('admin.routers.add-edit');
	}

	public function postAdd()
	{
		$input = Input::all();
		$this->flash( Router::create($input) );
		return Redirect::route(self::HOME);
	}


	public function getEdit($id)
	{
		try{
			$router = Router::findOrFail($id);
			return View::make('admin.routers.add-edit')
							->with('router',$router);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postEdit()
	{
		if( ! Input::has('id')){
			Notification::error('Parameter Missing.');
			return Redirect::route(self::HOME);
		}
		$input = Input::all();
		try{
			$router = Router::findOrFail($input['id']);
			$router->fill($input);
			$this->flash( $router->save() );
			return Redirect::route(self::HOME);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postDelete($id)
	{
		$this->flash( Router::destroy($id) );
		return Redirect::route(self::HOME);
	}
}