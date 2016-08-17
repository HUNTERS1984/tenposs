<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Analytics;

class AdminController extends Controller
{
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
    	return view('admin::pages.admin.top');
    }

    public function getAnalytic(){
        $visitorAweek = Analytics::getVisitorsAndPageViews(7);
        // dd($visitorAweek);
        return view('admin::pages.ga.week')->with(array('visitor'=>$visitorAweek));
    }
}
