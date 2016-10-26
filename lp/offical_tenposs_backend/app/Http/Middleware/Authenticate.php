<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Models\App;
use App\Models\Store;
class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('admin/login')->withErrors('Please login');
            }
        }
        $request->user = Auth::user();
        if ($request->user) {
            $request->app = App::whereUserId($request->user->id)->first();
            if ($request->app) {
                $request->stores =  Store::whereAppId($request->app->id)->get();
            }
            
        }
       
        return $next($request);
    }
}
