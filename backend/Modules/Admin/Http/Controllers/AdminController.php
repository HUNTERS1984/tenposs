<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\AppSetting;
use App\Models\AppTopMainImage;
use App\Utils\UploadHandler;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Analytics;
use App\Models\Component;
use Illuminate\Support\Facades\Auth;
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

    public function welcome()
    {
        return view('admin::pages.welcome');
    }

    public function coupon()
    {
        return view('admin::pages.admin.coupon');
    }

    public function globalpage()
    {
        $app_data = App::where('user_id', Auth::user()->id)->first();
        $component_all = Component::pluck('name', 'id');
        $data_component_source = array();
        $data_component_dest = array();
        if (count($app_data) > 0) {
            $app = AppSetting::where('id', $app_data->id);
            $app_settings = $app->first();
            if ($app_settings != null) {
//                $data_component_dest = $app->first()->components()->pluck('name', 'id')->toArray();
                $data_component_dest = DB::table('components')
                    ->join('rel_app_settings_sidemenus', 'components.id', '=', 'rel_app_settings_sidemenus.sidemenu_id')
                    ->where('rel_app_settings_sidemenus.app_setting_id', '=', $app_settings->id)
                    ->pluck('name', 'id');
//               dd($data_component_dest);
                if (count($data_component_dest) > 0) {
                    $data_component_source = array_diff($component_all->toArray(), $data_component_dest);
//                    $data_component_source = Component::all()->whereNotIn('id',$list_id)->get();
//                    $data_component_source = DB::table('components')->whereNotIn('id', [])->get();
                } else
                    $data_component_source = $component_all->toArray();
            }
        }
        return view('admin::pages.admin.global')->with(array('app_settings' => $app_settings, 'data_component_dest' => $data_component_dest, 'data_component_source' => $data_component_source));
    }

    public function menu()
    {
        return view('admin::pages.admin.menu');
    }

    public function news()
    {
        return view('admin::pages.admin.news');
    }

    public function photography()
    {
        return view('admin::pages.admin.photography');
    }

    public function staff()
    {
        return view('admin::pages.admin.staff');
    }

    public function top()
    {
        $all = Component::whereNotNull('top')->pluck('name', 'id');
        $app_data = App::where('user_id', Auth::user()->id)->first();
        $app_components = array();
        $available_components = array();
        if (count($all) > 0) {
//            $app_components = $app->first()->components()->whereNotNull('top')->pluck('name', 'id')->toArray();
            $app = AppSetting::where('id', $app_data->id);
            $app_settings = $app->first();

            if ($app_settings != null) {
                $app_components = $app->first()->components()->pluck('name', 'id')->toArray();
                if (count($app_components) > 0) {
                    $available_components = array_diff($all->toArray(), $app_components);
                } else {
                    $available_components = $all->toArray();
                }

            }
        }
        return view('admin::pages.admin.top', compact('app_components', 'available_components'));
    }

    public function getAnalytic()
    {
        $visitorAweek = Analytics::getVisitorsAndPageViews(7);
        // dd($visitorAweek);
        return view('admin::pages.ga.week')->with(array('visitor' => $visitorAweek));
    }

    public function globalstore()
    {
//        $data = $this->request->all();

        try {
            $app_data = App::where('user_id', Auth::user()->id)->first();
            if (count($app_data) > 0) {
                $app = new AppSetting();
                $app_setting = $app->with('components')->find($app_data->id);
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
                $data_component = $this->request->input('data_component');
                $app_setting->save();
                $list_id = [];
                $list_insert = [];
                if (count($data_component) > 0) {
                    $app_data = App::where('user_id', Auth::user()->id)->first();
                    $app = new AppSetting();
                    $app_setting = $app->find($app_data->id);
                    $i = 1;
                    foreach ($data_component as $item) {
                        $list_id[] = $item;
                        $list_insert[] = array('app_setting_id' => $app_setting->id,
                            'sidemenu_id' => $item,
                            'order' => $i);
                        $i++;
                    }
                }
                if (count($list_id) > 0)
                    DB::table('rel_app_settings_sidemenus')->whereIn('app_setting_id', $list_id)->delete();
                if (count($list_insert) > 0)
                    DB::table('rel_app_settings_sidemenus')->insert($list_insert);

//        $app_setting->app_icon_color = $this->request->input('app_icon_color');
//        $app_setting->store_user_color = $this->request->input('store_user_color');


                //
                Session::flash('message', array('class' => 'alert-success', 'detail' => 'Add App Setting successfully'));
                return back();
            }
        } catch (QueryException $e) {
            Log::error("globalstore: " . $e->getMessage());
            Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Add App Setting fail'));
            return back();
        }
    }

    public function upload()
    {
        $app_data = App::where('user_id', Auth::user()->id)->first();

        if (count($app_data) > 0) {
            $app_setting = AppSetting::where('id', $app_data->id)->first();
            if (count($app_setting) > 0) {
                $upload = new UploadHandler($app_data->id, $app_setting->id);
            }
        }

//        return $upload;
    }


    public function uploaddelete()
    {
        $app_data = App::where('user_id', Auth::user()->id)->first();

        if (count($app_data) > 0) {
            $app_setting = AppSetting::where('id', $app_data->id)->first();
            if (count($app_setting) > 0) {
                $top_image_id = Input::get('top_image_id');
                $file_name = Input::get('file');
                $app_setting_id = Input::get('app_setting_id');
                if ($app_setting_id == $app_setting->id) {
                    //delete record all database
                    $file_path = '/uploads/' . $app_data->id . '/' . $file_name;
                    DB::table('app_top_main_images')->where('image_url', $file_path)->delete();
//                    $top_image = AppTopMainImage::find($top_image_id);
//                    if (count($top_image) > 0) {
//                        $top_image->delete();

                    //delete file
                    $upload = new UploadHandler($app_data->id, $app_setting->id, null, false, null);
                    $upload->delete(true);
//                    }
                }
            }
        }

//        return $upload;
    }


    public function topstore()
    {
        try {

            $data_component = $this->request->input('data_component');
            $list_id = [];
            $list_insert = [];
            if (count($data_component) > 0) {
                $app_data = App::where('user_id', Auth::user()->id)->first();
                if (count($app_data) > 0) {
                    $app = new AppSetting();
                    $app_setting = $app->with('components')->find($app_data->id);
                    $i = 1;
                    foreach ($data_component as $item) {
                        $list_id[] = $item;
                        $list_insert[] = array('app_setting_id' => $app_setting->id,
                            'component_id' => $item,
                            'order' => $i);
                        $i++;
                    }
                }
            }
            if (count($list_id) > 0)
                DB::table('rel_app_settings_components')->whereIn('app_setting_id', $list_id)->delete();
            if (count($list_insert) > 0)
                DB::table('rel_app_settings_components')->insert($list_insert);

            Session::flash('message', array('class' => 'alert-success', 'detail' => 'Add Side Menu successfully'));
            return back();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Add App Setting fail'));
            return back();
        }
    }

    public function waiting()
    {
        return view('admin::pages.auth.waiting');
    }

}