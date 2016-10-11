<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use DB;
use URL;
use Config;

class VerifyExistApp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( !Session::has('app') ){
           
            $post = \App\Utils\HttpRequestUtil::getInstance()
                ->get_data('get_app_by_domain',[
                    'domain' => URL::to('/')
                ],Config::get('api.secret_key_for_domain')
            );    
        
            $response = json_decode($post);
    
            if( \App\Utils\Messages::validateErrors($response) && count($response->data->app_info) > 0 ){
                
                $app = DB::table('apps')
                    ->where('app_app_id', $response->data->app_info->app_app_id )
                    ->first();
                Session::put('app',$app);  
                
            }else{
                Session::flash('message', \App\Utils\Messages::getMessage( $response ));
                abort(404);
            }
            
        }

        return $next($request);
    }
}
