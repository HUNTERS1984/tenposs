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
use JWTAuth;

class ClientsController extends Controller
{
    protected $url_register = 'https://auth.ten-po.com/auth/register';
    protected $url_login = 'https://auth.ten-po.com/auth/login';
    protected $api_approvelist = 'https://auth.ten-po.com/approvelist';
    protected $api_active = 'https://auth.ten-po.com/activate';
    protected $api_create_vir = 'https://api.ten-po.com/api/v1/create_virtual_host';
    
    public function __construct()
    {
        
    }
    public function index(){
        // Get profile
        $response = cURL::newRequest('get',$this->api_approvelist)
            ->setHeader('Authorization',  'Bearer '. JWTAuth::getToken()  );
           
        $response = $response->send();
         
        $response = json_decode($response->body);
      
        if( isset($response->code) && $response->code == 1000 ){
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
            
            if( !empty($response) &&  isset($response->code) && $response->code == 1000 ){
                Session::put('jwt_token',$response->data);
                return redirect()->route('admin.home');
            }
            
            return back()->withErrors( 'Login fail!' );

        }
        return view('admin.login');
    }

    public function logout(){
        Session::forget('jwt_token');
        return redirect()->route('admin.home');
    }

    public function show($user_id){

        $response = cURL::newRequest('get',$this->api_approvelist)
            ->setHeader('Authorization',  'Bearer '. JWTAuth::getToken()  );
           
        $response = $response->send();
        $response = json_decode($response->body);
        if( !empty($response) && isset($response->code) && $response->code == 1000 ){
 
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
        // get all users
        $response = cURL::newRequest('get',$this->api_approvelist)
            ->setHeader('Authorization',  'Bearer '. JWTAuth::getToken()  );

        $response = $response->send();
        $response = json_decode($response->body);
        if( !empty($response) && isset($response->code) && $response->code == 1000 ){

            $user =  \App\Helpers\ArrayHelper::searchObject($response->data, $request->input('user_id') );
            if( $user ){
                // Get user to approved
                $userInfos =  DB::table('user_infos')
                    ->where('id',$request->input('user_id'))
                    ->first();

                // API active user
                $requestActive = cURL::newRequest('get',$this->api_active)
                    ->setHeader('Authorization',  'Bearer '. JWTAuth::getToken()  );
                $responseActive = $requestActive->send();
                $responseActive = json_decode($responseActive->body);
                if( isset($responseActive->code) && $responseActive->code == 1000 ){

                }
                // API create virtual hosts
                /*
                $requestCreateVir = cURL::post($this->api_create_vir, 
                    [
                        'domain' => $userInfos->domain, 
                        'domain_type' => $userInfos->domain_type,
                        'time' => '',
                        'sig' => ''
                    ]
                );
                
                $responseCreateVir = json_decode( $requestCreateVir->body );
                if( $responseCreateVir->code == 1000 ){
                    
                }    
                */
    
    
                // Send mail to user approved
                try{
                    $to = $user->email ;

                    Mail::send('admin.emails.user_approved',
                        array('user' => $user)
                        ,function($message) use ( $user, $to ) {
                            $message->from( config('mail.from')['address'], config('mail.from')['name'] );
                            $message->to( $to )
                                //->cc()
                                ->subject('お申し込み受付のお知らせ【TENPOSS】');
                        });
                    return response()->json(['success' => true]);
                }
                catch(Exception $e){

                }
                // Create apps setting default
                // Create app default info
                $app = new \App\Models\App;
                $app->name = $userInfos->app_name_register;
                $app->app_app_id = md5(uniqid(rand(), true));
                $app->app_app_secret = md5(uniqid(rand(), true));
                $app->description =  'なし';
                $app->status = 1;
                $app->business_type = $userInfos->business_type;
                $app->user_id = $user->id;
                $app->save();

                // Set default app templates 1
                $templateDefaultID = 1;

                $appSetting = new \App\Models\AppSetting;
                $appSetting->app_id = $app->id;
                $appSetting->title = 'Default';
                $appSetting->title_color = '#b2d5ef';
                $appSetting->font_size = '12';
                $appSetting->font_family = 'Arial';
                $appSetting->header_color = '#aee30d';
                $appSetting->menu_icon_color = '#eb836f';
                $appSetting->menu_background_color = '#5a15ee';
                $appSetting->menu_font_color = '#5ad29f';
                $appSetting->menu_font_size = '12';
                $appSetting->menu_font_family = 'Tahoma';
                $appSetting->template_id = $templateDefaultID;
                $appSetting->top_main_image_url = 'uploads/1.jpg';
                $appSetting->save();

                // Set rel_app_settings_sidemenus, rel_app_settings_components

                $component = DB::table('components')
                    ->whereNotNull('sidemenu')
                    ->get();

                $i = 0;$j = 0;
                foreach( $component as $com){
                    if( $com->top !== '' ){
                        DB::table('rel_app_settings_components')->insert(
                            [
                                'app_setting_id' => $appSetting->id,
                                'component_id' => $com->id
                            ]
                        );
                        $j++;
                    }


                    if( $com->sidemenu !== '' ){
                        DB::table('rel_app_settings_sidemenus')->insert([
                            'app_setting_id' => $appSetting->id,
                            'sidemenu_id' => $com->id,
                            'order' => $i
                        ]);
                        $i++;
                    }


                }
                // Create app_stores,rel_apps_stores default

                $stores_default = DB::tables('app_stores')->all();

                foreach($stores_default as $store){

                    DB::table('rel_apps_stores')->insert([
                        'app_id' => $app->id,
                        'app_store_id' => $store->id,
                        'version' => '1.0'
                    ]);

                }

                // setting default rel_app_stores
                DB::table('app_top_main_images')->insert([
                    'app_setting_id' => $appSetting->id,
                    'image_url' =>  'uploads/1.jpg',
                ]);
                return response()->json(['success' => true ]);
            }
            
            
        }

        return response()->json(['success' => false, 'msg' => 'Try again!' ]);
    }

}
