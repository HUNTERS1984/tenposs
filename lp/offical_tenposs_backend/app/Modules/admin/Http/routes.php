<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('admin/login',['as'=>'admin.login','uses'=>'AuthController@getLogin']);
Route::post('admin/login',['as'=>'admin.login.post','uses'=>'AuthController@postLogin']);
Route::get('admin/register',['as'=>'admin.register','uses'=>'AuthController@getRegister']);
Route::post('admin/register',['as'=>'admin.register.post','uses'=>'AuthController@postRegister']);

Route::group(['prefix' => 'admin','middleware'=>['web','admin']], function() {
	Route::get('dashboard',['as'=>'admin.dashboard','uses'=>'AdminController@index']);
	Route::get('logout','AdminController@getLogout');

	// BLOG
	Route::post('blog/status',['as'=>'admin.blog.status','uses'=>'BlogController@status']);
	Route::resource('blog','BlogController');

	// INTERGRATION
	Route::post('intergration/status',['as'=>'admin.intergration.status','uses'=>'IntergrationController@status']);
	Route::resource('intergration','IntergrationController');

	// NEWS
	Route::post('news/status',['as'=>'admin.news.status','uses'=>'NewsController@status']);
	Route::resource('news','NewsController');

	// PARTNERSHIP
	Route::post('partnership/status',['as'=>'admin.partnership.status','uses'=>'PartnershipController@status']);
	Route::resource('partnership','PartnershipController');

	// STARTGUIDE
	Route::post('startguide/status',['as'=>'admin.startguide.status','uses'=>'StartguideController@status']);
	Route::resource('startguide','StartguideController');

	// FAQ
	Route::post('faq/status',['as'=>'admin.faq.status','uses'=>'FaqController@status']);
	Route::post('faq/add-more-type',['as'=>'admin.faq.add_type','uses'=>'FaqController@add_type']);
	Route::get('faq/delete-type/{id}',['as'=>'admin.faq.delete_type','uses'=>'FaqController@delete_type'])->where(['id'=>'[A-Za-z)-9.\-\/]+']);
	Route::post('faq/edit-type/{id}',['as'=>'admin.faq.edit_type','uses'=>'FaqController@edit_type'])->where(['id'=>'[A-Za-z)-9.\-\/]+']);
	Route::resource('faq','FaqController');

	// INTRODUCTION
	Route::post('introduction/status',['as'=>'admin.introduction.status','uses'=>'IntroductionController@status']);
	Route::post('introduction/add-more-type',['as'=>'admin.introduction.add_type','uses'=>'IntroductionController@add_type']);
	Route::get('introduction/delete-type/{id}',['as'=>'admin.introduction.delete_type','uses'=>'IntroductionController@delete_type'])->where(['id'=>'[A-Za-z)-9.\-\/]+']);
	Route::post('introduction/edit-type/{id}',['as'=>'admin.introduction.edit_type','uses'=>'IntroductionController@edit_type'])->where(['id'=>'[A-Za-z)-9.\-\/]+']);
	Route::resource('introduction','IntroductionController');

	//CONTACT
	Route::post('contact/status',['as'=>'admin.contact.status','uses'=>'ContactController@status']);
	Route::resource('contact','ContactController',['only'=>['index','show','destroy']]);
});

