<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\Repositories\Contracts\AppsRepositoryInterface;
use Validator;
use Auth;
use DB;
use Mail;
use Session;

class ClientsController extends Controller
{
    
	protected $userRespository;
    
    public function __construct(UsersRepositoryInterface $ur,AppsRepositoryInterface $appRepoInterface)
    {
        $this->userRespository = $ur;
        $this->appRepo = $appRepoInterface;
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

        // Assign role
        if( !$user->hasRole('client') )
            $user->assignRole('client');
      
        try{
			$to = $user->email ;
			$link = route('clients.verifined.registration', [ 'hascode' => $user->temporary_hash ] );
			Mail::send('admin.emails.user_approved',
				 array('user' => $user, 'link' => $link)
				 ,function($message) use ( $user, $to ) {
					 $message->from( config('mail.from')['address'], config('mail.from')['name'] );
					 $message->to( $to )
						 //->cc()
						 ->subject('お申し込み受付のお知らせ【TENPOSS】');
				 });
			return response()->json(['success' => true]);	 
		 }
		 catch(Exception $e){
			// fail
			return response()->json(['success' => 'false', 'msg' => 'Try again!' ]);
		 }

        return response()->json(['success' => 'false', 'msg' => 'Try again!' ]);
    }
    
    public function verifinedApprovedUser(Request $request, $hascode ){
        if( $request->has('hascode') ){
            abort(503);
        }
        
        $user = \App\Models\User::where('temporary_hash', $hascode)->firstOrFail();
        if( $user ){
            $user->status = 1;
            $user->temporary_hash = '';
            $user->save();
            $user->createAppSettingDefault();
            return redirect('https://ten-po.com/admin/login');

        }
        abort(503);
    }
    
}
