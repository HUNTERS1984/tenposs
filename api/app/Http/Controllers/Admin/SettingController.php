<?php

namespace App\Http\Controllers\Admin;

use App\Utils\HttpRequestUtil;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use cURL;
use DB;
use Mail;
use Session;
use JWTAuth;
use Config;
use App\Models\AdminGlobalSettings;


class SettingController extends Controller
{
	public function setting(){
		$setting = AdminGlobalSettings::first();
		return view('admin.global.setting', array( 'setting' => $setting ));
	}

	public function settingPost(Request $request){
		if( $request->has('admin_email') ){
			AdminGlobalSettings::update(array(
				'admin_email' => $request->input('admin_email')
			));
			return back()->with('success', 'Update success');
		}
		return back()->with('error', 'Update fail');
		
	}
}