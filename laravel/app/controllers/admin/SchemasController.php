<?php

Class SchemasController extends AdminBaseController {

	public function getIndex()
	{
		$t = PolicySchema::paginate(10);
		return View::make('admin.schemas.index',['schemas'=>$t]);
	}

	public function getAdd()
	{
		$t = SchemaTemplate::lists('name','id');
		return View::make('admin.schemas.add-edit',['templates'=>$t]);
	}

	public function postAdd()
	{
		$input = Input::all();

		$rules = Config::get('validations.policy_schemas');
		$rules['name'][] = 'unique:policy_schemas';

		$v = Validator::make($input, $rules);
		if( $v->fails() ) {
			return Redirect::back()->withInput()->withErrors($v);
		}

		$this->flash( PolicySchema::create($input) );
		return Redirect::route('schema.index');
	}

	public function getEdit($id)
	{
		try{
			$schema = PolicySchema::findOrFail($id);
			$t = SchemaTemplate::lists('name','id');
			return View::make('admin.schemas.add-edit',['templates'=>$t])->with('schema',$schema);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postEdit()
	{
		try{
			$input = Input::all();
			$rules = Config::get('validations.policy_schemas');
			$rules['name'][] = 'unique:policy_schemas,name,' . $input['id'];

			$v = Validator::make($input, $rules);
			if( $v->fails() ) {
				return Redirect::back()->withInput()->withErrors($v);
			}

			$schema = PolicySchema::findOrFail($input['id']);
			$schema->fill($input);

			$this->flash( $schema->save() );
			return Redirect::route('schema.index');
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postDelete($id)
	{
		$this->flash( PolicySchema::destroy($id) );
		return Redirect::route('schema.index');
	}

	public function getTemplateIndex()
	{
		$temps = SchemaTemplate::paginate(10);
		return View::make('admin.schematemplates.index',['templates'=>$temps]);
	}

	public function getAddTemplate()
	{
		$times = Config::get('times', NULL);
		$policies = Policy::lists('name','id');
		return View::make('admin.schematemplates.add-edit',['times'=>$times,'policies'=>$policies]);
	}

	public function postAddTemplate()
	{
		$rules = Config::get('validations.schema_templates');
		$input = Input::all();
		
		$v = Validator::make($input, $rules);
		
		if( $v->fails() ) {
			$this->notifyError("Form Validatoin Failed, Please verify input data.");
			return Redirect::back()->withErrors($v)->withInput();
		}
		$template = new SchemaTemplate;

		$template = $this->parseTemplate($template, $input);
		$this->flash( $template->save() );
		
		return Redirect::route('schematemplate.index');
	}

	public function getEditTemplate($id)
	{
		try{
			$template = SchemaTemplate::findOrFail($id);

			$times = Config::get('times',NULL);
			$policies = Policy::lists('name','id');
			return View::make('admin.schematemplates.add-edit',['template'=>$template,'times'=>$times,'policies'=>$policies]);
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postEditTemplate()
	{
		try{
			$input = Input::all();
			$template = SchemaTemplate::findOrFail($input['id']);
			$template->fill($input);

			$this->flash($template->save());

			return Redirect::route('schematemplate.index');
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	public function postDeleteTemplate($id)
	{
		try{
			$this->flash( SchemaTemplate::destroy($id) );
			return Redirect::route('schematemplate.index');
		}
		catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			App::abort(404);
		}
	}

	private function parseTemplate($template,$input)
	{
		$template->name = $input['name'];
		$template->access = $input['access'];

		switch( $input['access'] )
		{
			case 0 :
			$template->bw_policy = $input['bw_policy'];
			$template->bw_accountable = $input['bw_accountable'];
						break;

			case 2 :
			$template->from_time = $input['from_time'];
			$template->to_time = $input['to_time'];
			$template->pr_allowed = $input['pr_allowed'];

			if( $template->pr_allowed ) {
				$template->pr_policy = $input['pr_policy'];
				$template->pr_accountable = $input['pr_accountable'];
			}
				
			$template->sec_allowed = $input['sec_allowed'];
			if( $template->sec_allowed ) {
				$template->sec_policy = $input['sec_policy'];
				$template->sec_accountable = $input['sec_accountable'];
			}
					break;
		}

		return $template;
	}
}

//end of file SchemasController.php