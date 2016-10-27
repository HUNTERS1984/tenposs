<?php
  
namespace App\Http\Controllers;
  
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Illuminate\Support\Facades\Hash;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller{
    

  
    public function __construct()
    {

        
    }

    
    public function register(Request $request){

        $check_items = array('email', 'password', 'role');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        try {
            $this->validate($request, [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);
        } catch (HttpResponseException $e) {
            return $this->error(1004);
        }

        if (Input::get('role') == 'admin')
            return $this->error(1004); 

        try {
            $user = User::where('email', Input::get('email'))->first();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        if ($user)
            return $this->error(9996);
        try {
            DB::beginTransaction();
            $user = new User();
            $user->email = Input::get('email');
            $user->password = app('hash')->make(Input::get('password'));
            $user->save();

            $role = Role::whereSlug(Input::get('role'))->first();
            if ($role)
                $user->attachRole($role);
            else {
                DB::rollBack();
                return $this->error(1004); 
            }   

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return $this->error(9999);
        }

        $user = User::whereEmail(Input::get('email'))->with('roles')->first();

        $credentials = array();
        $credentials['email'] = Input::get('email');
        $credentials['password'] = Input::get('password');

        if ($user && $user->roles && count($user->roles) > 0 && $token = JWTAuth::attempt($credentials, ['role' => $user->roles[0]->slug])) {
            $this->body['data'] = $token;
            return $this->output($this->body);
        } else {
            return $this->error(9995);
        }



        return $this->output($this->body);
    }

    public function delete(Request $request){
        $user = JWTAuth::toUser();

        if (!$user)
            return $this->error(1004);

        try {
            DB::beginTransaction();

            $user->detachAllRoles();
            $user->delete();

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return $this->error(9999);
        }

        return $this->output($this->body);
    }

    public function profile(Request $request){
        $user = JWTAuth::toUser();

        if (!$user)
            return $this->error(1004);

        $this->body['data'] = $user;

        return $this->output($this->body);
    }

    public function userlist(Request $request){
        $user = JWTAuth::toUser();

        if (!$user)
            return $this->error(1004);

        if ($user->isRole('admin')) {
            $userlist = User::with('roles')->get();
            $this->body['data'] = $userlist;
            return $this->output($this->body);
        } else {
            return $this->error(9997);
        }
        
    }


    public function activate(Request $request){
        $user = JWTAuth::toUser();

        if (!$user)
            return $this->error(1004);

        if ($user->isRole('admin')) {
            $user = User::whereEmail(Input::get('email'))->first();
            if ($user)
            {
                $user->active = 1;
                $user->save();
                return $this->output($this->body);
            } else {
                return $this->error(1004); 
            }
            
        } else {
            return $this->error(9997);
        }
        
    }
  
}