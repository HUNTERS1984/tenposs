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
           
            $url = URL::to('/');
            $url = parse_url($url,PHP_URL_HOST);
            $url = strstr(str_replace("www.","",$url), ".",true);

            $url = 'm';
            $post = \App\Utils\HttpRequestUtil::getInstance()
                ->get_data('get_app_by_domain',[
                    'domain' => $url
                ],Config::get('api.secret_key_for_domain')
            );

            $response = json_decode($post);

            if( $response->code == 1000  ){
                $app = DB::table('apps')
                    ->where('app_app_id', $response->data->app_info->app_app_id )
                    ->first();

                if( is_null($app) )
                    abort(404);
                Session::put('app',$app);  
                
            }else{
                Session::flash('message', \App\Utils\Messages::getMessage( $response ));
                abort(404);
            }
            
        }

        return $next($request);
    }
}
