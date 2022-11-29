<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;
use Closure;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
   Log::info('This is my log', ['request' => getallheaders()]);
   return $next($request);
    }
}
