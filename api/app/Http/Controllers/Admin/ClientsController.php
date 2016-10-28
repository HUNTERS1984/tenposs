<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use cURL;
use DB;
use Mail;
use Session;

class ClientsController extends Controller
{
    protected $url_register = 'https://auth.ten-po.com/auth/register';
    protected $url_login = 'https://auth.ten-po.com/auth/login';
    protected $api_approvelist = 'https://auth.ten-po.com/approvelist';
    
    public function __construct()
    {
        
    }
    public function index(){
        // Get profile
        $response = cURL::newRequest('get',$this->api_approvelist)
            ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')  );
           
        $response = $response->send();
         
        $response = json_decode($response->body);
      
        if( $response->code == 1000 ){
            return view('admin.clients.index',['users'=> $response->data ]);
        }
        
        return redirect()->route('login');
        
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $rules = array(
                'email' => 'required|email|max:255',
                'password' => 'required'
            );
            $v = Validator::make($request->all(),$rules);
            if( $v->fails() ){
                return back()->withInput()->withErrors($v);
            }
            
            $response = cURL::post($this->url_login, 
                [
                    'email' => $request->input('email'), 
                    'password' => $request->input('password'),
                    'role' => 'admin'
                ]
            );
            
            $response = json_decode( $response->body );
            if( $response->code == 1000 ){
                Session::put('jwt_token',$response->data);
                return redirect()->route('admin.home');
            }
            
            return back()->withErrors( $response->message );

        }
        return view('admin.login');
    }

    public function logout(){
        Session::forget('jwt_token');
        return redirect()->route('admin.home');
    }

    public function show($user_id){
        
        // Get profile
        $response = cURL::newRequest('get',$this->api_approvelist)
            ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')  );
           
        $response = $response->send();
         
        $response = json_decode($response->body);
      
        if( $response->code == 1000 ){
 
            $user =  \App\Helpers\ArrayHelper::searchObject($response->data, $user_id );
            $userInfos =  DB::table('user_infos')
                ->where('id',$user_id)->first();
                
            $apps = DB::table('apps')
                ->where( 'apps.user_id', $user_id )
                ->get();
                
            return view('admin.clients.show',[
                'user' => $user, 
                'userInfos' => $userInfos, 
                'apps' => $apps  ]);
        }
        return redirect()->route('login');
        
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
