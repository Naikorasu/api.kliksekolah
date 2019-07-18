<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$userRoles)
    {
        if(Auth::check()) {
            if(Auth::user()->authorizeRole($roles)) {
              return $next($request);
            }
        }
    }
}
