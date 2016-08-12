<?php

namespace App\Http\Middleware;
use Auth;
use App\Models\UserSession;
use Closure;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;

class AppAuthMiddleware
{
    private function get_user($token) {
        if (!$token || $token == '')
            return null;

        $session = UserSession::where('token', $token)->first();

        if ($session) {
            $user = $session->app_user()->with('profile')->first();
            return $user;
        }
        return null;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {   
        try {
            
            $token = Input::get('token');
            $user = $this->get_user($token);
            //dd($token); die();
            if (!$user) {
                return Response::json(['code' => '9998', 'message' => 'Token is invalid.', 'data' => []]);
            }
            $request->user = $user;
        } catch (\Illuminate\Database\QueryException $e) {
            return Response::json(['code' => '9999', 'message' => 'Exception error.', 'data' => []]);
        }

        
        return $next($request);
    }


}
