<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

error_reporting(E_ALL);
ini_set('display_errors', 'on');


//$app->group(['middleware' => 'jwt.auth'], function ($app) {
//    $app->post('/user/set_push_key','NotificationController@user_set_push_key');
//});
$app->group(array('prefix' => 'v1', 'middleware' => 'jwt.auth'), function ($app) {
    $app->post('/user/set_push_key','NotificationController@user_set_push_key');
    $app->post('/user/set_push_setting','NotificationController@user_set_push_setting');
    $app->post('/user/notification','NotificationController@user_notification');
    $app->post('/staff/set_push_key','NotificationController@staff_set_push_key');
    $app->post('/staff/notification','NotificationController@staff_notification');
    $app->post('/configure_notification','NotificationController@configure_notification');
    $app->get('/get_configure/{app_id}','NotificationController@get_configure_notification');
});
$app->group(['middleware' => 'jwt.refresh'], function ($app) {

});

$app->get('/test','NotificationController@test');