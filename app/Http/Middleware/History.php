<?php

namespace App\Http\Middleware;

use Closure;
use App\Auth;
use App\History;

class History
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $entity ,$id)
    {
        $response = $next($request);

        History::save([
          'entity' => $entity,
          'entity_id' => $id,
          'value' => $request,
          'user_id' => Auth::user()->id
        ])

        return $response;
    }
}
