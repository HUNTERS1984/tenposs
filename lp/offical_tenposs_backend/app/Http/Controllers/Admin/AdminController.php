<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use Cache;
use JWTAuth;
use Carbon\Carbon;

use App\Models\App;
use App\Models\AppStores;
use App\Models\AppSetting;
use App\Models\AppTopMainImage;
use App\Models\AdminContacts;
use App\Models\UserInfos;
use App\Models\Template;

use App\Utils\RedisControl;
use App\Utils\RedisUtil;
use App\Utils\UploadHandler;
use App\Utils\UrlHelper;

use Illuminate\Database\QueryException;
use Validator;
use cURL;
use Analytics;
use App\Models\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AdminController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function dashboard(){
        return view('admin.pages.global');
    }
    
    public function top(Request $request){
        $all = Component::whereNotNull('top')->pluck('name', 'id');

        $app_data = App::whereUserId($request->user['sub'] )->first();

        if( !$app_data ){
            return redirect()->route('user.dashboard');
        }
        $app_components = array();
        $top_images = array();
        $available_components = array();
        if (count($all) > 0) {
//            $app_components = $app->first()->components()->whereNotNull('top')->pluck('name', 'id')->toArray();
            $app = App::where('id', $app_data->id)->first();
            $app_settings = $app->app_setting()->first();
            if ($app_settings != null) {

                $top_images = AppTopMainImage::where('app_setting_id', '=', $app_settings->id)->get();
                for ($i = 0; $i < count($top_images); $i++) {
                    $top_images[$i]->image_url = UrlHelper::convertRelativeToAbsoluteURL(url('/'),$top_images[$i]->image_url);
                }
                $app_components = $app_settings->components()
                    ->whereNotNull('top')
                    ->pluck('name', 'id')
                    ->toArray();
                if (count($app_components) > 0) {
                    $available_components = array_diff($all->toArray(), $app_components);
                } else {
                    $available_components = $all->toArray();
                }
            } else {
                return redirect()->route('user.dashboard');
            } 
            
        }
        
        

        $slides = DB::table('app_top_main_images')
            ->where('app_setting_id', $app_settings->id)
            ->get();
        
        $photos = DB::table('apps')
            ->join('stores','apps.id','=','stores.app_id')
            ->join('photo_categories','photo_categories.store_id','=','stores.id')
            ->join('photos','photos.photo_category_id','=','photo_categories.id' )
            ->where('apps.id', $app_data->id)
            ->whereNull('photos.deleted_at')
            ->whereNull('photo_categories.deleted_at')
            ->whereNull('stores.deleted_at')
            ->select('photos.image_url')
            ->paginate(9);
            
        $news = DB::table('apps')
            ->join('stores','apps.id','=','stores.app_id')
            ->join('new_categories','new_categories.store_id','=','stores.id')
            ->join('news','news.new_category_id','=','new_categories.id' )
            ->where('apps.id', $app_data->id)
            ->whereNull('news.deleted_at')
            ->whereNull('new_categories.deleted_at')
            ->whereNull('stores.deleted_at')
            ->select('news.*')
            ->paginate(4);   

        $items = DB::table('apps')
            ->join('stores','apps.id','=','stores.app_id')
            ->join('menus','menus.store_id','=','stores.id')
            ->join('rel_menus_items','menus.id','=','rel_menus_items.menu_id' )
            ->join('items','items.id','=','rel_menus_items.item_id' )
            ->where('apps.id', $app_data->id)
            ->whereNull('items.deleted_at')
            ->whereNull('menus.deleted_at')
            ->whereNull('stores.deleted_at')
            ->select('items.*')
            ->paginate(4);
       
        $contacts = DB::table('apps')
            ->join('stores','apps.id','=','stores.app_id')
            ->join('addresses','addresses.store_id','=','stores.id')
            ->where('apps.id', $app_data->id)
            ->whereNull('stores.deleted_at')
            ->select('addresses.*')
            ->paginate(1);

        return view('admin.pages.top', 
        compact(    'slides','photos','news', 'items', 'contacts',
                    'app_components', 'top_images',
                    'available_components'));
    }

    public function help(Request $request){
        return view('admin.pages.help');
    }

    public function contact(Request $request){
        return view('admin.pages.contact');
    }

    public function saveContact(Request $request){
        $rules = [
            'name' => 'required|Max:255',
            'message' => 'required',
        ];
        $v = Validator::make($this->request->all(),$rules);
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            $contact = new AdminContacts();
            $contact->name = $this->request->input('name');
            $contact->message = $this->request->input('message');

            $contact->save();
            return redirect()->route('admin.client.contact')->with('status','追加しました');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('追加に失敗しました');
        }
    }
    
    public function globalpage(Request $request)
    { 
        $app_data = App::where('user_id', $request->user['sub'])->first();
        if (!$app_data)
            return redirect()->route('user.dashboard');
        
        $component_all = DB::table('components')->whereNotNull('sidemenu')
            ->select('name', 'id','sidemenu_icon')
            ->get();
  
        
        $data_component_source = array();
        $data_component_dest = array();
        
        if (count($app_data) > 0) {
            $app_settings = AppSetting::where('app_id', $app_data->id)->first();
            //dd($app_data->id);
            if ($app_settings != null) {
                $data_component_dest = DB::table('components')
                    ->join('rel_app_settings_sidemenus', 'components.id', '=', 'rel_app_settings_sidemenus.sidemenu_id')
                    ->where('rel_app_settings_sidemenus.app_setting_id', '=', $app_settings->id)
                    ->whereNotNull('components.sidemenu')
                    ->select('name', 'id','sidemenu_icon')
                    ->orderBy('rel_app_settings_sidemenus.order', 'ASC')
                    ->get();
               
                if (count($data_component_dest) > 0) {
                    
                    $data_component_source = array_udiff(
                            $component_all, 
                            $data_component_dest,
                            function ($obj_a, $obj_b) {
                                return $obj_a->id - $obj_b->id;
                            }
                        );
                } else
                    $data_component_source = $component_all;
            } else {
                return redirect()->route('user.dashboard');
            }
        }
        
        $list_font_size = Config::get('font.size');
        $list_font_family = Config::get('font.family');
        $list_theme = Template::whereNull('deleted_at')->get()->pluck('name', 'id');
        //dd($list_theme);
        // Get app_stores
        $app_stores = DB::table('app_stores')
            ->join('rel_apps_stores','rel_apps_stores.app_store_id','=','app_stores.id')
            ->join('apps','apps.id','=','rel_apps_stores.app_id')
            ->where('rel_apps_stores.app_id',$app_data->id)
            ->select('rel_apps_stores.*')
            ->first();
        //dd($data_component_dest);
        if( is_null($app_stores) || is_null($app_settings)  )
            abort(404);
        //dd($app_settings);
        return view('admin.pages.global')->with(
            array(
                'app_stores' => $app_stores,
                'app_settings' => $app_settings,
                'data_component_dest' => $data_component_dest,
                'data_component_source' => $data_component_source,
                'list_theme' => $list_theme,
                'list_font_size' => $list_font_size,
                'list_font_family' => $list_font_family));
    }
    
    public function globalstore(Request $request)
    {
       
        $app_data = App::where('user_id', $request->user['sub'])->firstOrFail();
        try {

            if (count($app_data) > 0) {
                // Save app_settings
                $app_setting = AppSetting::where('app_id', $app_data->id)->firstOrFail();
                //$app_setting = $app->with('components')->find($app_data->id);
                $app_setting->app_id = $app_data->id;
                $app_setting->title = $this->request->input('title');
                $app_setting->title_color = $this->request->input('title_color');
                $app_setting->font_size = $this->request->input('font_size');
                $app_setting->font_family = $this->request->input('font_family');
                $app_setting->header_color = $this->request->input('header_color');
                $app_setting->menu_icon_color = $this->request->input('menu_icon_color');
                $app_setting->menu_background_color = $this->request->input('menu_background_color');
                $app_setting->menu_font_color = $this->request->input('menu_font_color');
                $app_setting->menu_font_size = $this->request->input('menu_font_size');
                $app_setting->menu_font_family = $this->request->input('menu_font_family');
                $app_setting->company_info = $this->request->input('company_info');
                $app_setting->user_privacy = $this->request->input('user_privacy');
                $app_setting->template_id = $this->request->input('app_theme');
                $app_setting->save();
                
                
                // Save rel_app_settings_sidemenus
                $data_sidemenus = $this->request->input('data_sidemenus');
               

                if (count($data_sidemenus) > 0) {
                    DB::table('rel_app_settings_sidemenus')
                        ->where('app_setting_id', $app_setting->id)->delete();
                    
                    $i = 1;
                    $list_insert = array();
                    foreach ($data_sidemenus as $menu) {
                        
                        $list_insert[] = array(
                            'app_setting_id' => $app_setting->id,
                            'sidemenu_id' => $menu,
                            'order' => $i);
                        $i++;
                    }
                    //dd($list_insert);
                     DB::table('rel_app_settings_sidemenus')->insert($list_insert);
                    
                } else {
                     DB::table('rel_app_settings_sidemenus')
                        ->where('app_setting_id', $app_setting->id)->delete();
                }
                
                // save app_stores
                $app_icon = '';
                $store_image = '';
                if( $request->hasFile('file') ){
                    foreach( $request->file('file') as $key => $file ){
                        if( $file ) {
                            
                            $destinationPath = public_path('uploads'); // upload path
                            $extension = $file->getClientOriginalExtension(); // getting image extension
                            $fileName = md5($file->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
                            $file->move($destinationPath, $fileName); // uploading file to given path
                 
                            if( $key === 'app_icon' ){
                                $app_icon = 'uploads/' . $fileName;
                            }
                            if( $key === 'store_image' ){
                                $store_image = 'uploads/' . $fileName;
                            }
                        }
                    }
                }
                
                
            
                $app_stores = DB::table('app_stores')
                    ->join('rel_apps_stores','rel_apps_stores.app_store_id','=','app_stores.id')
                    ->join('apps','apps.id','=','rel_apps_stores.app_id')
                    ->where('rel_apps_stores.app_id',$app_data->id)
                    ->update([
                        'rel_apps_stores.app_icon_url' => $app_icon,
                        'rel_apps_stores.store_icon_url' => $store_image
                    ]);

                //delete cache redis
                RedisControl::delete_cache_redis('app_info');
                //Session::flash('message', array('class' => 'alert-success', 'detail' => 'Setting successfully'));
                return back()->with('status', '設定しました');
            }
        } catch (QueryException $e) {
            Log::error("globalstore: " . $e->getMessage());
            
            return back()->with('warning', '設定に失敗しました');
        }
    }
    
    public function topstore(Request $request)
    {
        try {
            $app_setting = null;
            $app_data = App::where('user_id', $request->user['sub'])->first();
            if (count($app_data) > 0) {
                $app = new AppSetting();
                $app_setting = $app->whereAppId($app_data->id)->with('components')->first();
                if (!$app_setting)
                    return back()->with('warning', '設定に失敗しました');
            } else {
                return back()->with('warning', '設定に失敗しました');
            }

            DB::beginTransaction();

            AppTopMainImage::where('app_setting_id', '=', $app_setting->id)->delete();
            if ($this->request->current_image) {
                foreach ($this->request->current_image as $image_file) {
                    if ($image_file != null) {
                        $top_image = new AppTopMainImage();
                        $top_image->image_url= parse_url($image_file, PHP_URL_PATH);
                        $top_image->app_setting_id = $app_setting->id;
                        $top_image->save();
                    }
                }
            }
            

            if ($this->request->image_viewer != null) {
                foreach ($this->request->image_viewer as $image_file) {
                    if ($image_file != null && $image_file->isValid()) {
                        $file = array('image_create' => $image_file);
                        $destinationPath = 'uploads'; // upload path
                        $extension = $image_file->getClientOriginalExtension(); // getting image extension
                        //$fileName = md5($image_file->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
                        $fileName = $image_file->getClientOriginalName();
                        $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
                        $contentType = mime_content_type($image_file->getRealPath());

                        if(! in_array($contentType, $allowedMimeTypes) ){
                            return redirect()->back()->withInput()->withErrors('アップロードファイルは写真ではありません');
                        }
                        $image_file->move($destinationPath, $fileName); // uploading file to given path
                        
                        $top_image = new AppTopMainImage();
                        $top_image->image_url= $destinationPath . '/' . $fileName;
                        $top_image->app_setting_id = $app_setting->id;
                        $top_image->save();
                    } 
                }
                
            }
            

            $data_component = $this->request->input('data_component');
            $list_id = [];
            $list_insert = [];
            $i = 1;
            if ($data_component) {
                foreach ($data_component as $item) {
                    $list_id[] = $item;
                    $list_insert[] = array('app_setting_id' => $app_setting->id,
                        'component_id' => $item,
                        'order' => $i);
                    $i++;
                }
                if (count($list_id) > 0)
                    DB::table('rel_app_settings_components')->where('app_setting_id', $app_setting->id)->delete();
                if (count($list_insert) > 0)
                    DB::table('rel_app_settings_components')->insert($list_insert);

            } else {
                DB::table('rel_app_settings_components')->where('app_setting_id', $app_setting->id)->delete();
            }
            
           
            //delete cache redis
            RedisControl::delete_cache_redis('app_info');
            RedisControl::delete_cache_redis('top_images');
            DB::commit();
            return back()->with('status', '設定しました');
        } catch (QueryException $e) {
            dd($e);
            Log::error($e->getMessage());
            DB::rollBack();
            return back()->with('warning', '設定に失敗しました');
        }
    }

    public function account(){

        $user_info = UserInfos::find( Session::get('user')->id );
        if(!$user_info){
            return abort(503,'ユーザーを見つけることができません' );
        }

        return view('admin.pages.users.account', ['user' => $user_info]);
    }

    public function accountSave(Request $request){

        $filePath = '';
        $warning = [];
        if( $request->hasFile('avatar') ) {
            $file = $request->file('avatar');
            $destinationPath = public_path('uploads/avatar'); // upload path
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $fileName = md5($file->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
            $file->move($destinationPath, $fileName); // uploading file to given path
            $filePath = 'uploads/avatar/'.$fileName;
        }
        $user_info = UserInfos::find(Session::get('user')->id );
        if(!$user_info){
            return abort(503);
        }
        if( $request->has('name') ){
            $message = array(
                'name.required' => '名前が必要です。',
                'name.min' => '名前は6文字以上でなければなりません。'
            );

            $validator = Validator::make( $request->all() , [
                'name' => 'required|min:3',
            ],$message);

            if ( $validator->fails() ) {
                return back()
                    ->withInput()
                    ->withErrors($validator);
            }
            $requestUpdateName = cURL::newRequest('post', Config::get('api.api_auth_updateprofile'),
                [
                    'name' => $request->input('name'),
                ])
                ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token  );
            $responseUpdateName = $requestUpdateName->send();
            //dd($responseUpdateName);
            $responseUpdateName = json_decode($responseUpdateName->body);

            if( !empty($responseUpdateName)
                && isset( $responseUpdateName->code )
                && $responseUpdateName->code == 1000 ){
                //$status[] = 'Update password success!';
            }else{
                $warning[] = '名前を編集できません';
            }
        }
        if( $request->has('password') ){

            $message = array(
                'current_password.required' => '現在パスワードフィールドが必要です。',
                'current_password.min' => '現在パスワードは6文字以上でなければなりません。',
                'password.required' => 'パスワードフィールドが必要です。',
                'password.min' => 'パスワードは6文字以上でなければなりません。',
                'password_confirm.same' => 'パスワードは一致しなければなりません。',
            );

            $validator = Validator::make( $request->all() , [
                'current_password' => 'required|min:6',
                'password' => 'required|min:6',
                'password_confirm' => 'required|same:password',
            ], $message);


            if ( $validator->fails() ) {
                return back()
                    ->withInput()
                    ->withErrors($validator);
            }
            $requestUpdatePassWord = cURL::newRequest('post', Config::get('api.api_auth_changepass'),
                [
                    'old_password' => $request->input('current_password'),
                    'new_password' => $request->input('password_confirm'),
                ])
                ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token  );
            $responseUpdatePassWord = $requestUpdatePassWord->send();
            //dd($responseUpdatePassWord);
            $responseUpdatePassWord = json_decode($responseUpdatePassWord->body);

            if( !empty($responseUpdatePassWord)
                && isset( $responseUpdatePassWord->code )
                && $responseUpdatePassWord->code == 1000 ){
                //$status[] = 'Update password success!';
            }else{
                $warning[] = 'パスワードを編集できません';
            }

        }


        $user_info->business_type = $request->input('business_type');
        $user_info->tel = $request->input('tel');
        $user_info->fax = $request->input('fax');
        $user_info->shop_category = $request->input('shop_category');
        $user_info->shop_url = $request->input('shop_url');
        $user_info->shop_tel = $request->input('shop_tel');
        $user_info->shop_regular_holiday = $request->input('shop_regular_holiday');
        $user_info->shop_business_hours = $request->input('shop_business_hours');
        $user_info->shop_address = $request->input('shop_address');
        $user_info->shop_name = $request->input('shop_name');
        $user_info->shop_description = $request->input('shop_description');

        if( $filePath != '' ) 
            $user_info->avatar = $filePath;
        $user_info->save();
        Session::put('user', null);

        $status[] = 'アカウントを編集しました';
        return back()
            ->with('warning',$warning )
            ->with('status',$status);
    }

    public function globalSaveAppIcon(Request $request){

        $img = $request->input('app_icon');
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file_name = uniqid() . '.png';
        if (!file_exists(public_path('uploads/app_icons/'))) {
            mkdir(public_path('uploads/app_icons/'), 0777, true);
        }
        $file = public_path('uploads/app_icons/') . $file_name;

        $success = file_put_contents($file, $data);
        if( $success ){
            //get all app_stores
            $app_stores = AppStores::all();
            if( $app_stores ){
                // get all rel_app_stores
                $rel_app_stores = DB::table('rel_apps_stores')
                       ->where('app_id', $request->app->id )->get();
                // update app_icon_url
                if( count($rel_app_stores) > 0 ){
                    foreach( $rel_app_stores as $real_app_store ){
                        DB::table('rel_apps_stores')
                            ->where('app_id', $request->app->id )
                            ->update(
                                array( 'app_icon_url' => 'uploads/app_icons/'.$file_name )
                            );
                    }
                }else{ // Create new
                    foreach( $app_stores as $item ){
                        DB::table('rel_apps_stores')
                            ->insert(array(
                                'app_id' => $request->app->id,
                                'app_store_id' => $item->id,
                                'app_icon_url' => 'uploads/app_icons/'.$file_name
                            ));
                    }
                }


            }
            return response()->json(array( 'success' => true, 'file' => url('uploads/app_icons/'.$file_name) ));
        }
        return response()->json(array( 'success' => false, 'msg' => 'Set app icon fail' ));

    }

    public function deleteSplashImage(Request $request){
        if( $request->has('img_name') ){
            $arrNames = array(
                'splash_image_1',
                'splash_image_2',
                'splash_image_3',
                'splash_image_4',
                'splash_image_5'
            );
            $img_name = $request->input('img_name');
            if( in_array($img_name,$arrNames ) ){
                $rel_app_stores = DB::table('rel_apps_stores')
                    ->where('app_id', $request->app->id )
                    ->update(array(
                        $img_name => ''
                    ));
                if( $rel_app_stores ){
                    return response()->json(array('success' => true));
                }
            }
        }
        return response()->json(array('success' => false));
    }

    public function globalSaveSplashImage(Request $request){

        $files = array();
        if( $request->hasFile('splash_image_1') ){
            $files['splash_image_1'] = $request->file('splash_image_1');
        }
        if( $request->hasFile('splash_image_2') ){
            $files['splash_image_2'] = $request->file('splash_image_2');
        }
        if( $request->hasFile('splash_image_3') ){
            $files['splash_image_3'] = $request->file('splash_image_3');
        }
        if( $request->hasFile('splash_image_4') ){
            $files['splash_image_4'] = $request->file('splash_image_4');
        }
        if( $request->hasFile('splash_image_5') ){
            $files['splash_image_5'] = $request->file('splash_image_5');
        }

        if( ! empty( $files ) ){
            foreach( $files as $key => $file ){
                $image_info = getimagesize($file);
                // check dementiosn
                if( $image_info[0] != 750 && $image_info[1] != 1334 )
                    return response()->json([
                        'success' => false,
                        'msg' => 'ファイルサイズは無効です'
                    ]);
                // save file
                $destinationPath = public_path('uploads/app_plash'); // upload path
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $fileName = md5($file->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
                $file->move($destinationPath, $fileName); // uploading file to given path
                $filePath = 'uploads/app_plash/'.$fileName;
                $rel_app_stores = DB::table('rel_apps_stores')
                    ->where('app_id', $request->app->id )
                    ->update(array(
                        $key => $filePath
                    ));
                if( $rel_app_stores )
                    return response()->json([
                        "success" => true,
                        "msg"=>"ファイルをアップロードしました"]);
                return response()->json([
                    "success" => false,
                    "msg"=>"ファイルをアップロードできません"]);
            }

        }

    }

    public function userManagement(Request $request){
        $search_str = $this->request->input('search_pattern'); 
        if ($search_str)
        {
            $users = DB::table('app_users')
            ->select('app_users.*', 
                'user_profiles.name AS username', 
                'user_profiles.avatar_url AS avatar', 
                'user_profiles.age AS age',
                'user_profiles.address AS address',
                'user_profiles.facebook_status AS facebook_status',
                'user_profiles.twitter_status AS twitter_status',
                'user_profiles.instagram_status AS instagram_status',
                'user_profiles.gender AS gender')
            ->join('user_profiles', 'app_users.id', '=', 'user_profiles.app_user_id')
            ->whereNull('app_users.deleted_at')
            ->whereNull('user_profiles.deleted_at')     
            ->where(function ($query) use ($search_str) {
                $query->where('name', 'LIKE', '%'. $search_str .'%' );
            })
            ->orderBy('app_users.updated_at', 'DESC')
            ->paginate(10);

            $users->appends($this->request->only('search_pattern'))->links();
        } else {
            $users = DB::table('app_users')
            ->select('app_users.*', 
                'user_profiles.name AS username', 
                'user_profiles.avatar_url AS avatar', 
                'user_profiles.age AS age',
                'user_profiles.address AS address',
                'user_profiles.facebook_status AS facebook_status',
                'user_profiles.twitter_status AS twitter_status',
                'user_profiles.instagram_status AS instagram_status',
                'user_profiles.gender AS gender')
            ->join('user_profiles', 'app_users.id', '=', 'user_profiles.app_user_id')
            ->whereNull('app_users.deleted_at')
            ->whereNull('user_profiles.deleted_at')
            ->orderBy('app_users.updated_at', 'DESC')
            ->paginate(10);
            
        }

        for ($i = 0; $i < count($users); $i++) {
            $response = cURL::newRequest('get', Config::get('api.api_point_user')."?app_id=".$this->request->app->app_app_id.'&user_id='.$users[$i]->id)
            ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();
            $point_info = json_decode($response->body);
            $users[$i]->point = 0;
            if ($point_info)
                $users[$i]->point = $point_info->data->miles;
            if ($users[$i]->avatar == null)
                $users[$i]->avatar = env('ASSETS_BACKEND') . '/images/icon-user.jpg';
            else
                $users[$i]->avatar = UrlHelper::convertRelativeToAbsoluteURL(url('/'), $users[$i]->avatar);
        }

        //dd($users);
        // Client
        $response = cURL::newRequest('get', Config::get('api.api_point_client')."?app_id=".$this->request->app->app_app_id)
                ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();
        $client = json_decode($response->body);
        if ($client) {
            $client = $client->data;
        }
        //dd($client);

        return view('admin.pages.users.users_management', array(
            'users' => $users,
            'client' => $client
        ));
    }

    public function userManagementPost(Request $request){
        if (count(Input::get('del_list')) > 0) {
            foreach (Input::get('del_list') as $item) {
                try {
                    DB::beginTransaction();
                    DB::table('social_profiles')
                        ->where('app_user_id', $item)
                        ->update(['deleted_at' => Carbon::now()]);
                    DB::table('user_profiles')
                        ->where('app_user_id', $item)
                        ->update(['deleted_at' => Carbon::now()]);
                    DB::table('app_users')
                        ->where('id', $item)
                        ->update(['deleted_at' => Carbon::now()]);
                    DB::commit();
                } catch (\Illuminate\Database\QueryException $e) {
                    DB::rollBack();
                    return json_encode(array('status' => 0));
                }
            }
            
            return json_encode(array('status' => 1));
        }
    }

    public function userManagementDetail(Request $request, $app_user_id){
        $app_user = AppUser::where('id',$app_user_id)->with('profile')->first();
        //dd($app_user->toArray());

        // Client
        $response = cURL::newRequest('get', Config::get('api.api_point_client')."?app_id=".$this->request->app->app_app_id)
                ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();
        $client = json_decode($response->body);
        if ($client) {
            $client = $client->data;
        }
        
        $url = cURL::buildUrl(Config::get('api.api_point_history'),
            [
                'app_id' => $request->app->app_app_id,
                'pageindex' => 1,
                'pagesize' => 20,
                'user_id' => $app_user_id
            ]);
        $response = cURL::newRequest('get', $url)
                ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();
        $history = json_decode($response->body);
        if ($history) {
            $history = $history->data;
        }


        if( $app_user ){
            return view('admin.pages.users.users_detail',array(
                'app_user' => $app_user,
                'client' => $client,
                'history' => $history,
            ));
        }
        return redirect()->back();
    }


}

