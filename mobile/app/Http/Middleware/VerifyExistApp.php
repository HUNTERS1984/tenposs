<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use DB;

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
            $app = DB::table('apps')
                    ->where('app_app_id','2a33ba4ea5c9d70f9eb22903ad1fb8b2')
                    ->first();
            Session::put('app',$app);        
        }
        return $next($request);
    }
}
