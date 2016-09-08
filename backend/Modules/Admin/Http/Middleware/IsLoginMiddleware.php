<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Auth;

class IsLoginMiddleware
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

        if(Auth::check()){
            return redirect()->back()->withErrors("You're already logined.");
        }
        return $next($request);
    }
}
