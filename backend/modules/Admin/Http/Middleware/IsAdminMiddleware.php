<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Auth;

class IsAdminMiddleware
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
        if(!Auth::user()->role || Auth::user()->role !== 'admin' ){
            return redirect()->back()->withErrors("You don't have permission");
        }
        return $next($request);
    }
}
