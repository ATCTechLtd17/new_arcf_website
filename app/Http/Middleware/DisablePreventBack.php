<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DisablePreventBack
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
     public function handle($request, Closure $next): mixed
     {
         $response = $next($request);

         return $response->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate')
             ->header('Pragma', 'no-cache')
             ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
     }
}
