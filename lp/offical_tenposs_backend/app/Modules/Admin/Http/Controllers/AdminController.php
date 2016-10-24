<?php

namespace App\Modules\admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function __construct(){
    	$this->middleware('admin');
    }

    public function index(){
    	return view('admin::pages.index.index');
    }

    public function getLogout(){
    	Auth::guard('admin')->logout();
    	return redirect()->route('admin.login');
    }
}

