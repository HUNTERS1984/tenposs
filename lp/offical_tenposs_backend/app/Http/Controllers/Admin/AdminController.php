<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use Cache;

use App\Models\App;
use App\Models\AppSetting;
use App\Models\AppTopMainImage;
use App\Models\AdminContacts;
use App\Models\UserInfos;

use App\Utils\RedisControl;
use App\Utils\RedisUtil;
use App\Utils\UploadHandler;
use App\Utils\UrlHelper;

use Illuminate\Database\QueryException;
use Validator;

use Analytics;
use App\Models\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
        $app_data = App::where('user_id', $request->user['sub'] )->first();
        if( !$app_data ){
            abort(503);
        }
        $app_components = array();
        $top_images = array();
        $available_components = array();
        if (count($all) > 0) {
//            $app_components = $app->first()->components()->whereNotNull('top')->pluck('name', 'id')->toArray();
            $app = AppSetting::where('id', $app_data->id);
            $app_settings = $app->firstOrFail();

            if ($app_settings != null) {

                $top_images = AppTopMainImage::where('app_setting_id', '=', $app_settings->id)->get();
                for ($i = 0; $i < count($top_images); $i++) {
                    $top_images[$i]->image_url = UrlHelper::convertRelativeToAbsoluteURL(url('/'),$top_images[$i]->image_url);
                }
                $app_components = $app->first()
                    ->components()
                    ->whereNotNull('top')
                    ->pluck('name', 'id')
                    ->toArray();
                if (count($app_components) > 0) {
                    $available_components = array_diff($all->toArray(), $app_components);
                } else {
                    $available_components = $all->toArray();
                }
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
            ->select('photos.image_url')
            ->paginate(9);
            
        $news = DB::table('apps')
            ->join('stores','apps.id','=','stores.app_id')
            ->join('new_categories','new_categories.store_id','=','stores.id')
            ->join('news','news.new_category_id','=','new_categories.id' )
            ->where('apps.id', $app_data->id)
            ->select('news.*')
            ->paginate(4);   

        $items = DB::table('apps')
            ->join('stores','apps.id','=','stores.app_id')
            ->join('menus','menus.store_id','=','stores.id')
            ->join('rel_menus_items','menus.id','=','rel_menus_items.menu_id' )
            ->join('items','items.id','=','rel_menus_items.item_id' )
            ->where('apps.id', $app_data->id)
            ->select('items.*')
            ->paginate(4);
       
        $contacts = DB::table('apps')
            ->join('stores','apps.id','=','stores.app_id')
            ->join('addresses','addresses.store_id','=','stores.id')
            ->where('apps.id', $app_data->id)
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
            return redirect()->route('admin.client.contact')->with('status','Add contact successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Cannot add contact');
        }
    }
    
    public function globalpage(Request $request)
    {
        
        $app_data = App::where('user_id', $request->user['sub'])->firstOrFail();
        $component_all = DB::table('components')->whereNotNull('sidemenu')
            ->select('name', 'id','sidemenu_icon')
            ->get();
  
    
        $data_component_source = array();
        $data_component_dest = array();
        
        if (count($app_data) > 0) {
            $app_settings = AppSetting::where('app_id', $app_data->id)->firstOrFail();
            
            if ($app_settings != null) {
                $data_component_dest = DB::table('components')
                    ->join('rel_app_settings_sidemenus', 'components.id', '=', 'rel_app_settings_sidemenus.sidemenu_id')
                    ->where('rel_app_settings_sidemenus.app_setting_id', '=', $app_settings->id)
                    ->whereNotNull('components.sidemenu')
                    ->select('name', 'id','sidemenu_icon')
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
            }
        }
        
        $list_font_size = Config::get('font.size');
        $list_font_family = Config::get('font.family');
        
        // Get app_stores
        $app_stores = DB::table('app_stores')
            ->join('rel_apps_stores','rel_apps_stores.app_store_id','=','app_stores.id')
            ->join('apps','apps.id','=','rel_apps_stores.app_id')
            ->where('rel_apps_stores.app_id',$app_data->id)
            ->select('rel_apps_stores.*')
            ->first();
//            dd($app_settings);
        return view('admin.pages.global')->with(
            array(
                'app_stores' => $app_stores,
                'app_settings' => $app_settings,
                'data_component_dest' => $data_component_dest,
                'data_component_source' => $data_component_source,
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
                $app_setting->template_id = 1;
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
                     DB::table('rel_app_settings_sidemenus')->insert($list_insert);
                    
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
                return back()->with('status', 'Setting successfully');
            }
        } catch (QueryException $e) {
            Log::error("globalstore: " . $e->getMessage());
            
            return back()->with('warning', 'Setting fail');
        }
    }
    
    public function topstore(Request $request)
    {
        try {
            $app_setting = null;
            $app_data = App::where('user_id', $request->user['sub'])->first();
            if (count($app_data) > 0) {
                $app = new AppSetting();
                $app_setting = $app->with('components')->find($app_data->id);
                if (!$app_setting)
                    return back()->with('warning', 'Add App Setting fail');
            } else {
                return back()->with('warning', 'Add App Setting fail');
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
                            return redirect()->back()->withInput()->withErrors('The uploaded file is not an image');
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
            foreach ($data_component as $item) {
                $list_id[] = $item;
                $list_insert[] = array('app_setting_id' => $app_setting->id,
                    'component_id' => $item,
                    'order' => $i);
                $i++;
            }

            if (count($list_id) > 0)
                DB::table('rel_app_settings_components')->whereIn('app_setting_id', $list_id)->delete();
            if (count($list_insert) > 0)
                DB::table('rel_app_settings_components')->insert($list_insert);
            //delete cache redis
            RedisControl::delete_cache_redis('app_info');
            DB::commit();
            return back()->with('status', 'Setting successfully');
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return back()->with('warning', 'Setting fail');
        }
    }

    public function account(){
        $user_info = UserInfos::find( Session::get('user')->id );
        if(!$user_info){
            return abort(503,'User info not found' );
        }

        return view('admin.pages.users.account', ['user' => $user_info]);
    }

    public function accountSave(Request $request){

        $filePath = '';
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
            return abort(503,'User info not found' );
        }
        $user_info->business_form = $request->input('business_form');
        $user_info->business_category = $request->input('business_category');
        $user_info->brand_name = $request->input('brand_name');
        $user_info->street_address = $request->input('street_address');
        $user_info->tel = $request->input('tel');
        $user_info->business_hours = $request->input('business_hours');
        $user_info->regular_holiday = $request->input('regular_holiday');
        $user_info->testimonial = $request->input('testimonial');
        $user_info->avatar = $filePath;
        $user_info->save();

        return back()->with('status','Saved successful!');
    }
}