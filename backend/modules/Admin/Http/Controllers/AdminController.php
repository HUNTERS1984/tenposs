<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Analytics;
use App\Models\Component;

class AdminController extends Controller
{
    public function __construct(Request $request){
        $this->request = $request;
    }

    public function welcome(){
    	return view('admin::pages.welcome');
    }

    public function coupon(){
    	return view('admin::pages.admin.coupon');
    }

    public function globalpage(){
    	return view('admin::pages.admin.global');
    }

    public function menu(){
    	return view('admin::pages.admin.menu');
    }

    public function news(){
    	return view('admin::pages.admin.news');
    }

    public function photography(){
    	return view('admin::pages.admin.photography');
    }

    public function staff(){
    	return view('admin::pages.admin.staff');
    }

    public function top(){
        $all = Component::whereNotNull('top')->pluck('name', 'id');
        $app_components =  $this->request->app->app_setting()->first()->components()->whereNotNull('top')->pluck('name', 'id')->toArray();
        $available_components = array_diff($all->toArray(),$app_components);
    	return view('admin::pages.admin.top', compact('app_components', 'available_components'));
    }

    public function getAnalytic(){
        $visitorAweek = Analytics::getVisitorsAndPageViews(7);
        // dd($visitorAweek);
        return view('admin::pages.ga.week')->with(array('visitor'=>$visitorAweek));
    }
}
