<?php

Class SystemController extends AdminBaseController {

	public function about()
	{
		return View::make('about');
	}
}