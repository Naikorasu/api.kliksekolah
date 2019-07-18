<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\History;

class HistoryLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next, $entity_id=null, $entity, $action)
     {
       $history = [
         'new_value' => $request->input('data'),
         'entity' => $entity,
         'entity_id' => $entity_id,
         'action' => $action,
         'user_id' => Auth::user()->id;
       ];

       $request->session->put('history', $history);

       return $next($request);
     }

     public function terminate($request, $response) {
       $history = $request->pull('history');

       History::create($history);
     }
}
