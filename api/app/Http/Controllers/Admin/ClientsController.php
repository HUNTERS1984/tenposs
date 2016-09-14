<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UsersRepositoryInterface;
use Validator;
use Auth;
use DB;
use Mail;
use Session;

class ClientsController extends Controller
{
    
	protected $userRespository;
    
    public function __construct(UsersRepositoryInterface $ur)
    {
        $this->userRespository = $ur;
    }
    public function index(){
  
        return view('admin.clients.index',['users'=>$this->userRespository->paginate(20)]);
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

    public function show($user_id){
        return view('admin.clients.show',['user' => \App\Models\User::findOrFail($user_id)]);
    }

    public function approvedUsers(){
        if( !Auth::check() ) abort(503);
        $users = DB::table('users')
            ->where('status',2)
            ->where('role','')
            ->get();
        return view('admin.clients.approved', ['users' => $users ]);    
    }
    
    public function approvedUsersProcess(Request $request){
        $user = \App\Models\User::findOrFail( $request->input('user_id') );
        $randPassword = str_random(8);
        $link = url('http://ten-po/admin/login');
        // Update user
        $user->status = 1;
        $user->password = bcrypt($randPassword);
        $user->save();
        // Assign role
        $user->assignRole('client');
    
        
         try{
			$to = $user->email ;
			 Mail::send('admin.emails.user_approved',
				 array('user' => $user, 'link' => $link, 'password' => $randPassword)
				 ,function($message) use ( $user,$to ) {
					 $message->from( env('MAIL_USERNAME','Tenpo') );
					 $message->to( $to )
						 //->cc()
						 ->subject('Tenpo - Approved user');
				 });
			return response()->json(['success' => true]);	 
		 }
		 catch(Exception $e){
			// fail
			return response()->json(['success' => 'false', 'msg' => 'Try again!' ]);
		 }

        return response()->json(['success' => 'false', 'msg' => 'Try again!' ]);
    }
}
