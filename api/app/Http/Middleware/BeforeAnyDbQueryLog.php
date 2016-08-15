<?php
namespace App\Http\Middleware;
use Closure;
use DB;
use Log;

class BeforeAnyDbQueryLog
{
    public function handle($request, Closure $next)
    {
        DB::enableQueryLog();
        return $next($request);
    }

    public function terminate($request, $response)
    {
        // Store or dump the log data...
        Log::info(
            DB::getQueryLog()
        );
    }
}