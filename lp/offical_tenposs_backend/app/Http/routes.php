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
   return view('pages.top');
});

Route::get('top',function(){
	return view('pages.top');
});

Route::get('agree',function(){
	return view('pages.agree');
});

Route::get('blog',['as'=>'blog','uses'=>'BlogController@select_all']);
Route::get('blog/{id}/{slug?}',['as'=>'blog.detail','uses'=>'BlogController@select_detail'])->where(['id'=>'[0-9A-Za-z.\-\/]+','slug'=>'[A-Za-z0-9.\-\/]+']);

Route::get('contact',['as'=>'getContact','uses'=>'ContactController@getContact']);
Route::post('contact',['as'=>'postContact','uses'=>'ContactController@postContact']);

Route::get('demo',function(){
	return view('pages.demo');
});

Route::get('faq',['as'=>'faq','uses'=>'FaqController@select_all']);

Route::get('fee',function(){
	return view('pages.fee');
});
Route::get('flow',function(){
	return view('pages.flow');
});
Route::get('function',function(){
	return view('pages.function');
});

Route::get('intergration01',function(){
	return view('pages.intergration01');
});

Route::get('intergration02',['as'=>'intergration02','uses'=>'IntergrationController@select_all']);
Route::get('intergration02/{id}/{slug?}',['as'=>'intergration02.detail','uses'=>'IntergrationController@select_detail'])
->where(['id'=>'[0-9A-Za-z.\-\/]+','slug'=>'[A-Za-z0-9.\-\/]+']);

Route::get('introduction-case01',['as'=>'introduction01','uses'=>'IntroductionController@select_all']);
Route::post('introduction-case01/ajax',['as'=>'introduction01.load','uses'=>'IntroductionController@loadAjax']);

Route::get('introduction-case02',function(){
	return view('pages.introduction-case02');
});

Route::get('introduction',function(){
	return view('pages.introduction');
});


Route::get('news',['as'=>'news','uses'=>'NewsController@select_all']);
Route::get('news/{id}/{slug?}',['as'=>'news.detail','uses'=>'NewsController@select_detail'])->where(['id'=>'[0-9A-Za-z.\-\/]+','slug'=>'[A-Za-z0-9.\-\/]+']);

Route::get('partnership01',function(){
	return view('pages.partnership01');
});
Route::get('partnership02',['as'=>'partnership02','uses'=>'PartnershipController@select_all']);
Route::get('partnership02/{id}/{slug?}',['as'=>'partnership02.detail','uses'=>'PartnershipController@select_detail'])->where(['id'=>'[0-9A-Za-z.\-\/]+','slug'=>'[A-Za-z0-9.\-\/]+']);

Route::get('policy',function(){
	return view('pages.policy');
});
Route::get('signage',function(){
	return view('pages.signage');
});
Route::get('startguide',function(){
	return view('pages.startguide');
});
Route::get('support',function(){
	return view('pages.support');
});

Route::get('company01',function(){
	return view('pages.company01');
});

Route::get('company02',function(){
	return view('pages.company02');
});
Route::get('company03',function(){
	return view('pages.company03');
});
Route::get('company04-01',function(){
	return view('pages.company04-01');
});
Route::get('company04-02',function(){
	return view('pages.company04-02');
});
Route::get('company05',function(){
	return view('pages.company05');
});

Route::get('signup',['as'=>'signup','uses'=>'Auth\AuthController@getRegister']);
Route::post('signup',['as'=>'signup.post','uses'=>'Auth\AuthController@postRegister']);

Route::get('users/authorize_email/{token}', 'Auth\AuthController@activateUser')->name('user.activate');

Route::get('login',['as'=>'login','uses'=>'Auth\AuthController@getLogin']);
Route::post('login',['as'=>'login.post','uses'=>'Auth\AuthController@postLogin']);
Route::get('logout', 'Auth\AuthController@logout');
// Route::get('logout',['as'=>'logout','uses'=>'Auth\AuthController@getLogout']);

Route::get('password/reset/{token?}',['as'=>'password.reset','uses'=>'Auth\PasswordController@showResetForm']);
Route::post('password/email',['as'=>'password.sendEmail','uses'=>'Auth\PasswordController@sendResetLinkEmail']);
Route::post('password/reset',['as'=>'password.reset','uses'=>'Auth\PasswordController@reset']);

// Route::get('make-unicode',function(){
// 	$blog = \App\Models\Faq::all();
// 	foreach($blog as $item){
// 		$item->slug = \Unicode::make($item->question);
// 		$item->save();
// 	}
// 	return "Done";
// });