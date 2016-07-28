<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('coupon',function(){
	return view('pages.coupon');
});
Route::get('global',function(){
	return view('pages.global');
});
Route::get('menu',function(){
	return view('pages.menu');
});
Route::get('news',function(){
	return view('pages.news');
});
Route::get('photography',function(){
	return view('pages.photography');
});
Route::get('staff',function(){
	return view('pages.staff');
});
Route::get('top',function(){
	return view('pages.top');
});
