<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Auth;

class IsAccessMiddleware
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
        if(!Auth::check()){
            return redirect('/admin/login')->withErrors('Please login');
        }
        if(Auth::user()->role !== 'admin' && Auth::user()->role !== 'staff'){
            Auth::logout();
            return redirect('admin/login')->withErrors('You can not access.');
        }
        return  $next($request);;
    }
}
