<?php
namespace Modules\Admin\Http\Controllers\Auth;

use App\Models\Users;
use Validator;
use Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\AdminLoginRequest;

use App\Http\Requests;


class AuthController extends Controller
{
	use AuthenticatesAndRegistersUsers, ThrottlesLogins ;


	protected $validator;
	protected $redirectTo = '/admin/top';
	protected $redirectPath = "admin/top";

	protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'=>'required',
        ]);
    }

    protected function create(array $data)
    {
        return Users::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role'=>$data['role'],
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
