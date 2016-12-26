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
        $response = cURL::newRequest('get', Config::get('api.api_auth_approvelist'))
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
                    return response()->json(['success' => false, 'msg' => 'User info not found!']);
                }    
                        
                // API active user
                $requestActive = cURL::newRequest('post', Config::get('api.api_auth_active'), [
                    'email' => $user->email
                ])->setHeader('Authorization', 'Bearer ' . JWTAuth::getToken());

                $responseActive = $requestActive->send();
                $responseActive = json_decode($responseActive->body);

                if (isset($responseActive->code) && $responseActive->code == 1000) {
                    $arr_msg[] = '1. Activated user success! <br/>';
                } else {
                    return response()->json(['success' => false, 'msg' => 'Activated user fail!']);
                }

                // API create virtual hosts
                
                $requestCreateVir = cURL::post(Config::get('api.api_create_vir'),
                    [
                        'domain' => $userInfos->domain,
                        'domain_type' => $userInfos->domain_type,
                        'time' => '',
                        'sig' => ''
                    ]
                );

                $responseCreateVir = json_decode( $requestCreateVir->body );
                if( isset($responseCreateVir->code) && $responseCreateVir->code == 1000 ){
                     $arr_msg[] = '2. Created site'.$userInfos->domain.'ten-po.com success! <br/>';
                }else{
                    return response()->json(['success' => false, 'msg' => 'Creating virtual hosts fail !']);
                }
                


                // Send mail to user approved
                try {
                    $setting = AdminGlobalSettings::find(1);
                    
                    $to = $setting->admin_email ;
                    $to = 'phanvannhien@gmail.com';


                    Mail::send('admin.emails.user_approved',
                        array('user' => $user)
                        ,function($message) use ( $user, $to ) {
                            $message->from( config('mail.from')['address'], config('mail.from')['name'] );
                            $message->to( $to )
                                //->cc()
                                ->subject('お申し込み受付のお知らせ【TENPOSS】');
                        });

                    $arr_msg[] = '3. Sent email to admin success! <br/>' ;
                } catch (Exception $e) {

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
                }


                // Set default app templates
                $templates = \App\Models\Template::first();
                if (empty($templates)) {
                    $templates->name = 'Default Templates';
                    $templates->save();
                }


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
                $arr_msg[] = '5. Set App template default success! <br/>';

                $store = new \App\Models\Store;
                $store->app_id = $app->id;
                $store->name = 'Default Store';
                $store->save();
                $arr_msg[] = '6. Set App store default success! <br/>';

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

                // Set rel_app_settings_sidemenus, rel_app_settings_components
                $component = DB::table('components')
                    ->whereNotNull('sidemenu')
                    ->get();

                $i = 0;
                $j = 0;
                foreach ($component as $com) {
                    if ($com->top !== '') {
                        DB::table('rel_app_settings_components')->insert(
                            [
                                'app_setting_id' => $appSetting->id,
                                'component_id' => $com->id
                            ]
                        );
                        $j++;
                    }


                    if ($com->sidemenu !== '') {
                        DB::table('rel_app_settings_sidemenus')->insert([
                            'app_setting_id' => $appSetting->id,
                            'sidemenu_id' => $com->id,
                            'order' => $i
                        ]);
                        $i++;
                    }


                }
                $arr_msg[] = '8. Set app components top and menus success! <br/>';
                // Create app_stores,rel_apps_stores default

                $stores_default = DB::table('app_stores')->get();
                if (count($stores_default) > 0) {
                    foreach ($stores_default as $store) {

                        DB::table('rel_apps_stores')->insert([
                            'app_id' => $app->id,
                            'app_store_id' => $store->id,
                            'version' => '1.0'
                        ]);

                    }
                }
                $arr_msg[] = 'Set app stores success!';

                // setting default rel_app_stores
                DB::table('app_top_main_images')->insert([
                    'app_setting_id' => $appSetting->id,
                    'image_url' => 'uploads/1.jpg',
                ]);
                $arr_msg[] = '9. Set app top main images success! <br/>';
                Session::flash( 'success' , $arr_msg[]  );
                return response()->json(['success' => true]);
            }


        }

        return response()->json(['success' => false, 'msg' => 'Try again!']);
    }

}
