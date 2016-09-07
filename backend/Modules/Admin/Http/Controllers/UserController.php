<?php namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Models\User

class UserController extends Controller {
	
	public function index()
	{
		return view('admin::index');
	}
	
}