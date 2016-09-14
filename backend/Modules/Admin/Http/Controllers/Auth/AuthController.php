<?php
namespace Modules\Admin\Http\Controllers\Auth;

use App\Models\Users;
use Validator;
use Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;


use App\Http\Requests;


class AuthController extends Controller
{
	use AuthenticatesAndRegistersUsers, ThrottlesLogins ;


	protected $validator;
	protected $redirectTo = '/admin/news';
	protected $redirectPath = "admin/news";

	protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
//            'password' => 'required|min:6|confirmed',
			'password' => 'required|min:3|confirmed',
			'password_confirmation' => 'required|min:3',
            'business_type'=>'required',
            'app_name_register'=>'required'
        ]);
    }

    protected function create(array $data)
    {
        return Users::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'business_type'=>$data['business_type'],
            'business_type'=>$data['business_type'],
            'app_name_register'=>$data['app_name_register'],
            'domain'=>$data['domain'],
            'company'=>$data['company'],
            'tel'=>$data['tel'],
            'fax'=>$data['fax'],
			'status' => 2
        ]);
    }

	public function showLoginForm()
	{
		if (Auth::check())
		{
			if(Auth::user()->role() === 'admin'){
				return redirect()->route('admin::pages.admin.dashboard');
			}else{
				Auth::logout();
				return $this->showLoginForm();
			}
		}
		return view('admin::pages.auth.login');
	}

	public function showRegistrationForm()
	{
		return view('admin::pages.auth.register');
	}

	public function resetPassword()
	{
		return view('admin.auth.passwords.email');
	}

	public function logout(){
		Auth::logout();
		return redirect('/admin/login');
	}

}
