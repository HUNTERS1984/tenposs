<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use Cache;

use App\Models\App;
use App\Models\AppSetting;
use App\Models\AppTopMainImage;

use App\Utils\RedisControl;
use App\Utils\RedisUtil;
use App\Utils\UploadHandler;

use Illuminate\Database\QueryException;


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
        $available_components = array();
        if (count($all) > 0) {
//            $app_components = $app->first()->components()->whereNotNull('top')->pluck('name', 'id')->toArray();
            $app = AppSetting::where('id', $app_data->id);
            $app_settings = $app->firstOrFail();

            if ($app_settings != null) {
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
            ->paginate(9);   
       
        return view('admin.pages.top', 
        compact(    'slides','photos','news',
                    'app_components', 
                    'available_components'));
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
}