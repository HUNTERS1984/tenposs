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

use Illuminate\Support\Facades\Redis;
use Predis\Connection\ConnectionException;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/push', function () {
	for ($i = 0; $i < 10; $i++)
    	Redis::publish('channel', json_encode(['mes' => 'test7']));
});