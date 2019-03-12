<?php

namespace App\Http\Middleware;

use Closure;

class PreflightResponse
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
        if ($request->getMethod() === "OPTIONS") {

            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Method: POST, GET, OPTIONS, PUT, DELETE');
            header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Key, Authorization, Naikorasu');
            header('Access-Control-Allow-Credentials: true');
        }
        return $next($request);
    }





}
