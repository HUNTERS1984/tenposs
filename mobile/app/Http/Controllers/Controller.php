<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    protected $app_info;
    protected $app;
    
    public function __construct(){
       
        $this->app = Session::get('app');
       
        $get = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo',[
            'app_id' => $this->app->app_app_id ],
            $this->app->app_app_secret);
        
        $response = json_decode($get);
        
        if( \App\Utils\Messages::validateErrors($response) ){
            $this->app_info = $response;
        }else{
            abort(404);
        }

    }
    
    
}
