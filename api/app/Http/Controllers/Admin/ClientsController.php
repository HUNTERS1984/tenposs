<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UsersRepositoryInterface;
use Validator;
use Auth;
use Session;
class ClientsController extends Controller
{
    
	protected $userRespository;
    
    public function __construct(UsersRepositoryInterface $ur)
    {
        $this->userRespository = $ur;
    }
    public function index(){
  
        return view('admin.clients.index',['users'=>$this->userRespository->paginate(2)]);
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $rules = array(
                'email' => 'required|email',
                'password' => 'required'
            );
            $v = Validator::make($request->all(),$rules);
            if( $v->fails() ){
                return back()->withInput()->withErrors($v);
            }
            $authData = array(
                'email' =>  $request->input( 'email' ),
                'password' => $request->input( 'password' ),
            );
            if (Auth::attempt($authData))
            {
                return redirect()->route('admin.home');
            }
            Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Login fail!') );
            return back()->withInput();
        }
        return view('admin.login');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }


}
