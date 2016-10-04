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

$appRoutes = function () {
    Route::group([
        'middleware' => ['verify.app'],
        'middlewareGroups' => ['web']], function () {

        Route::get('/', 'MobileController@index');

        Route::get('/sign-in', ['as' => 'login', 'uses' => 'MobileController@login']);
        Route::get('/sign-up', ['as' => 'signup', 'uses' => 'LoginController@signup']);
        Route::post('/sign-up', ['as' => 'signup.post', 'uses' => 'LoginController@signupPost']);

        Route::get('/sign-out', ['as' => 'logout', 'uses' => 'LoginController@logout']);

        //Social Login
        Route::get('/login/{provider?}', [
            'uses' => 'LoginController@getSocialAuth',
            'as' => 'auth.getSocialAuth'
        ]);
        Route::get('/login/callback/{provider?}', [
            'uses' => 'LoginController@getSocialAuthCallback',
            'as' => 'auth.getSocialAuthCallback'
        ]);


        //Menu
        Route::get('/menus', [
            'uses' => 'MenusController@index',
            'as' => 'menus.index']);
        Route::get('/menus_detail', [
            'uses' => 'MenusController@detail',
            'as' => 'menus.detail']);
    });
};


Route::group(['domain' => '{name}.' . env('APP_DOMAIN')], $appRoutes);
Route::group(['domain' => env('APP_DOMAIN')], $appRoutes);


Route::get('/test', function () {
    $arr = array('app_id' => '2a33ba4ea5c9d70f9eb22903ad1fb8b2');
    $secret_key = "ádsadsadsa"; //lay tu app_app_secret
    return \App\Utils\HttpRequestUtil::getInstance()->get_data('appinfo', $arr, $secret_key);

    $arr_post = array('email' => 'bangnk@a.a',
        'password' => '123456',
        'app_id' => '2a33ba4ea5c9d70f9eb22903ad1fb8b2');
    $secret_key = "ádsadsadsa"; //lay tu app_app_secret
    return \App\Utils\HttpRequestUtil::getInstance()->post_data('signin', $arr_post, $secret_key);
});




