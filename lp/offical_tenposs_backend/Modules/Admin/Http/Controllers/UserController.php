<?php namespace Modules\Admin\Http\Controllers;


class UserController extends Controller {
	
	public function index()
	{
		return view('admin::index');
	}
	
}