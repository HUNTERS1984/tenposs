<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use Session;
use File;
use \Curl\Curl;
use Theme;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected $app_info;
    protected $app;
    protected $request;

    public function __construct(Request $request)
    {

        if( !Session::has('app') ){
            abort(404);
        }
        $this->request = $request;
        $this->app = Session::get('app');
        $get = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo', [
                'app_id' => $this->app->app_app_id],
                $this->app->app_app_secret);

        $response = json_decode($get);

        if ( isset($response->code) && $response->code == 1000 ) {
            $this->app_info = $response;

            if( $this->app_info->data->app_setting->template_id == 1 ){
                Theme::init('default');
            }else{
                Theme::init('restaurant');
            }
            // write file manifest

            if(!File::exists( public_path($response->data->id) )) {
                File::makeDirectory( public_path($response->data->id) , 0777, true, true);
            }
            if( $file = @file_get_contents($this->app_info->data->notification->url_manifest) )
                if( $file ){
                    File::put( public_path($response->data->id.'/manifest.json') , $file );
                }
                
        } else {
            abort(404);
        }

    }

}
