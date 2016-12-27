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
use App\Models\AppBots;
use App\Models\AdminGlobalSettings;


class ClientsController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        // Get approve list
        /*
        $response = cURL::newRequest('get', Config::get('api.api_auth_approvelist'))
            ->setHeader('Authorization', 'Bearer ' . JWTAuth::getToken());
        $response = $response->send();
        $response = json_decode($response->body);
        */
        // Get user list
        $requestUserLists = cURL::newRequest('get', 'https://auth.ten-po.com/userlist')
            ->setHeader('Authorization', 'Bearer ' . JWTAuth::getToken())->send();

        $userLists = json_decode($requestUserLists->body);
        usort($userLists->data, function ($item1, $item2) {
            if ($item1->active == $item2->active) return 0;
            return $item1->active < $item2->active ? -1 : 1;
        });

        if ( isset($userLists->code) && $userLists->code == 1000 ) {
            return view('admin.clients.index',
                ['usersLists' => $userLists->data]);
        }

        return redirect()->route('login')->withErrors('Please login');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = array(
                'email' => 'required|email|max:255',
                'password' => 'required'
            );
            $v = Validator::make($request->all(), $rules);
            if ($v->fails()) {
                return back()->withInput()->withErrors($v);
            }

            $response = HttpRequestUtil::getInstance()->post_data_with_basic_auth(Config::get('api.api_auth_login'),
                [
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'role' => 'admin'
                ]
            );

//            $response = json_decode($response->body);
//            if (!empty($response) && isset($response->code) && $response->code == 1000) {
//                Session::put('jwt_token', $response->data);
//                Session::put('user', $request->all());
//
//                return redirect()->route('admin.home');
//            }
            if ($response != null) {

                Session::put('jwt_token', $response->token);
                Session::put('user', $request->all());

                return redirect()->route('admin.home');
            }

            return back()->withErrors('Login fail!');

        }
        return view('admin.login');
    }

    public function logout()
    {
        Session::forget('jwt_token');
        Session::forget('user');
        return redirect()->route('admin.home');
    }

    public function show($user_id)
    {

        $response = cURL::newRequest('get', Config::get('api.api_auth_approvelist'))
            ->setHeader('Authorization', 'Bearer ' . JWTAuth::getToken());

        $response = $response->send();
        $response = json_decode($response->body);
        $userInfos = array();
        if (!empty($response) && isset($response->code) && $response->code == 1000) {

            $user = \App\Helpers\ArrayHelper::searchObject($response->data, $user_id);

            if (!$user) {
                $requestUserActiveList = cURL::newRequest('get', Config::get('api.api_auth_userlist'))
                    ->setHeader('Authorization', 'Bearer ' . JWTAuth::getToken());
                $responseUserActiveList = $requestUserActiveList->send();
                $responseUserActiveList = json_decode($responseUserActiveList->body);
                $user = \App\Helpers\ArrayHelper::searchObject($responseUserActiveList->data, $user_id);

                if (!$user) {
                    abort(503);
                }
            }

            $response_profile = cURL::newRequest('get', Config::get('api.api_user_v1_profile'))
                ->setHeader('Authorization', 'Bearer ' . JWTAuth::getToken());
            if (!empty($response_profile) && isset($response_profile->code) && $response_profile->code == 1000) {
                $userInfos = $response_profile->data;
            }

//            $userInfos =  DB::table('user_infos')
//                ->where('id',$user_id)->first();
//
//            if( !$userInfos ){
//                return back()->withErrors('Cannot access, Users info not found!');
//        }

            $apps = DB::table('apps')
                ->where('apps.user_id', $user_id)
                ->get();

            return view('admin.clients.show', [
                'user' => $user,
                'userInfos' => $userInfos,
                'apps' => $apps]);
        }
        return redirect()->route('login');

    }

    public function configLineBOT($user_id, $app_id){
        $appbot = AppBots::where('user_id', $user_id)
            ->where('user_id',$user_id)
            ->first();

        if( !$appbot ){
            $appbot = new AppBots;
            $appbot->user_id = $user_id;
            $appbot->app_id = $app_id;
            $appbot->save();
        }
        return view('admin.apps.linebot',array(
            'linebot' => $appbot,
            'user_id' => $user_id,
            'app_id' => $app_id
        ));

    }

    public function configLineBOTSave(Request $request, $user_id, $app_id){
        $appbot = AppBots::where('user_id', $user_id)
            ->where('user_id',$user_id)
            ->first();
        if($appbot){
            $appbot->chanel_id = $request->input('chanel_id');
            $appbot->chanel_secret = $request->input('chanel_secret');
            $appbot->chanel_access_token = $request->input('chanel_access_token');
            $appbot->add_friend_href = $request->input('add_friend_href');
            $appbot->qr_code_href = $request->input('qr_code_href');
            $appbot->save();
        }
        return back()->with('success', 'Update success');

    }



    public function approvedUsersProcess(Request $request)
    {
        // get all users

        $response = cURL::newRequest('get', 'https://auth.ten-po.com/userlist')
            ->setHeader('Authorization', 'Bearer ' . JWTAuth::getToken());
            
        $response = $response->send();
        $response = json_decode($response->body);
        if (!empty($response) && isset($response->code) && $response->code == 1000) {

            $user = \App\Helpers\ArrayHelper::searchObject($response->data, $request->input('user_id'));
            if ($user) {

                $arr_msg = array();
                // Get user to approved
                $userInfos = DB::table('user_infos')
                    ->where('id', $request->input('user_id'))
                    ->first();

                if( !$userInfos ){
                    return back()->withErrors('User info not found!');
                }    
                // Creating virual host


                $domain = '';
                if ( $userInfos->domain_type == 'main')
                    $domain = $userInfos->domain ;
                else if ( $userInfos->domain_type == 'sub')
                    $domain = $userInfos->domain . '.ten-po.com';
                if (!empty($domain)) {

                    $fileName = Config::get('api.path_host_apache_site_available').$domain.'.conf';
                    if( !file_exists( $fileName ) ){
                        try {
                            $source_file = public_path('assets/template/apache-host.txt'); // upload path
                            $template = file_get_contents($source_file);
                            $template = str_replace("#domain#", $domain, $template);
                            $dest_file = Config::get('api.path_host_apache_site_available');
                            $newFile = fopen($dest_file . $domain . '.conf', 'w');
                            fwrite($newFile, $template);
                            fclose($newFile);
                            $arr_msg[] = '2. Created site'.$userInfos->domain.'ten-po.com success! <br/>';
                        } catch (FileNotFoundException $e) {
                            Log::error($e->getMessage());
                            return back()->withErrors('Creating virtual hosts fail !');
                        } catch (FileException $e) {
                            Log::error($e->getMessage());
                            return back()->withErrors('Creating virtual hosts fail !');
                        }
                    }else{
                        $arr_msg[] = '2. Vitural hosts'.$userInfos->domain.' created before! <br/>';
                    }

                }

                // Create apps setting default
                // Create app default info
                $app = \App\Models\App::where('user_id', $user->id)->first();
               

                if( !$app ){
                    $app = new \App\Models\App;
                    $app->name = $userInfos->app_name_register;
                    $app->app_app_id = md5(uniqid(rand(), true));
                    $app->app_app_secret = md5(uniqid(rand(), true));
                    $app->description = 'なし';
                    $app->status = 1;
                    $app->user_id = $user->id;
                    $app->business_type = $userInfos->business_type;
                    $app->domain_type = $userInfos->domain_type;
                    $app->domain = $userInfos->domain;
                    $app->save();
                    $arr_msg[] = '4. App created! <br/>';
                }else{
                    $arr_msg[] = '4. App has been created before! <br/>';
                }


                // Set default app templates
                $templates = \App\Models\Template::first();
                if (empty($templates)) {
                    $templates->name = 'Default Templates';
                    $templates->save();
                }

                $appSetting = \App\Models\AppSetting::where('app_id', $app->id)->first();
                if( !$appSetting ){
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
                    $appSetting->template_id = $templates->id;
                    $appSetting->top_main_image_url = 'uploads/1.jpg';
                    $appSetting->save();
                    $arr_msg[] = '5. Set App setting default success! <br/>';
                }else{
                    $arr_msg[] = '5. App setting has been created before! <br/>';
                }
                
                $store = \App\Models\Store::where('app_id', $app->id)->first();
                if( !$store ){
                    $store = new \App\Models\Store;
                    $store->app_id = $app->id;
                    $store->name = 'Default Store';
                    $store->save();
                    $arr_msg[] = '6. Set App store default success! <br/>';
                }else{
                    $arr_msg[] = '6. App store has been created before! <br/>';
                }

                $address = \App\Models\Address::where('store_id', $store->id)->first();
                if( !$address ){
                    $response = cURL::newRequest('get', "https://maps.googleapis.com/maps/api/geocode/json?address=".$userInfos->shop_address)->send();
                    $response = json_decode($response);

                    $address = new \App\Models\Address;
                    $address->store_id = $store->id;
                    $address->title = $userInfos->shop_address;
                    $address->tel = $userInfos->shop_tel;
                    
                    if ($response)
                    {
                        $address->latitude= $response->results[0]->geometry->location->lat;
                        $address->longitude= $response->results[0]->geometry->location->lng;
                    }

                    $address->save();
                    $arr_msg[] = '7. Set addresses success! <br/>';
                }else{
                    $arr_msg[] = '7. Addresses has been created before! <br/>';
                }
                
                // Set rel_app_settings_sidemenus, rel_app_settings_components

                $rel_app_settings_components = DB::table('rel_app_settings_components')
                    ->where('app_setting_id',$appSetting->id)
                    ->get();

                if( count($rel_app_settings_components) <= 0 )   {
                    $component = DB::table('components')
                        ->whereNotNull('sidemenu')
                        ->get();

                    $i = 0;
                    foreach ($component as $com) {
                        if ($com->top !== '') {
                            DB::table('rel_app_settings_components')->insert(
                                [
                                    'app_setting_id' => $appSetting->id,
                                    'component_id' => $com->id
                                ]
                            );
                            $i++;
                        }
                    }
                    $arr_msg[] = '8. Set app components success! <br/>';
                } else{
                    $arr_msg[] = '8. App components has been created before! <br/>';
                }


                $rel_app_settings_components =  DB::table('rel_app_settings_components')
                    ->where('app_setting_id', $appSetting->id)->get();

                if( count($rel_app_settings_components) <= 0 )  {
                    $component = DB::table('components')
                        ->whereNotNull('sidemenu')
                        ->get();

                    $i = 0;
                    foreach ($component as $com) {
                       
                        if ($com->sidemenu !== '') {
                            DB::table('rel_app_settings_sidemenus')->insert([
                                'app_setting_id' => $appSetting->id,
                                'sidemenu_id' => $com->id,
                                'order' => $i
                            ]);
                            $i++;
                        }

                    }
                    $arr_msg[] = '8. Set app menus success! <br/>';
                }  

               
                // Create app_stores,rel_apps_stores default

                $stores_default = DB::table('app_stores')->get();
                if (count($stores_default) > 0) {
                    foreach ($stores_default as $store) {
                        $app_store = DB::table('rel_apps_stores')
                            ->where('app_id',$app->id)
                            ->where('app_store_id',$store->id)
                            ->get();

                        if( count($app_store) <= 0 ){
                            DB::table('rel_apps_stores')->insert([
                                'app_id' => $app->id,
                                'app_store_id' => $store->id,
                                'version' => '1.0'
                            ]);
                            $arr_msg[] = 'Set app stores '.$store->id.' success!';
                        }else{
                            $arr_msg[] = 'App stores '.$store->id.' created before!';
                        }
                    }
                }
                
                // setting default rel_app_stores
                $app_top_main_images = DB::table('app_top_main_images')
                    ->where('app_setting_id', $appSetting->id)
                    ->get();

                if( count($app_top_main_images) <= 0 ){ 
                    DB::table('app_top_main_images')->insert([
                        'app_setting_id' => $appSetting->id,
                        'image_url' => 'uploads/1.jpg',
                    ]);
                    $arr_msg[] = '9. Set app top main images success! <br/>';
                }else{
                    $arr_msg[] = '9. App top main created before! <br/>';
                }

                // Active user
                if( $user->active == 0){
                    
                    $requestActive = cURL::newRequest('post', Config::get('api.api_auth_active'), [
                        'email' => $user->email
                    ])->setHeader('Authorization', 'Bearer ' . JWTAuth::getToken());

                    $responseActive = $requestActive->send();
                    $responseActive = json_decode($responseActive->body);

                    if (isset($responseActive->code) && $responseActive->code == 1000) {
                        $arr_msg[] = '1. Activated user success! <br/>';
                    } else {
                        return back()->withErrors('Activated user fail!');
                    }
                }else{
                     $arr_msg[] = '10. User has been activated! <br/>';
                }

                // Send mail to user approved
                try {
                    $setting = AdminGlobalSettings::find(1);
                    
                    $to = $setting->admin_email ;
                    $to = 'phanvannhien@gmail.com';


                    $sentMail = Mail::send('admin.emails.user_approved',
                        array('user' => $user)
                        ,function($message) use ( $user, $to ) {
                            $message->from( config('mail.from')['address'], config('mail.from')['name'] );
                            $message->to( $to )
                                //->cc()
                                ->subject('お申し込み受付のお知らせ【TENPOSS】');
                        });
                    if( $sentMail ){
                        $arr_msg[] = '3. Sent email to admin success! <br/>' ;
                    }else{
                        return back()->withErrors('Sending mail fail !');
                    }
                    
                } catch (Exception $e) {

                }

               
                return back()->with('success', $arr_msg[]);
            }


        }

        return back()->withErrors('User not found!');
    }

}
