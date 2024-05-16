<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiSecureCheck
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->header('Api-Secure-Key') == env('SECURE_API_KEY')) {
            return $next($request);
        }

        return response()->json(['code' => 401, 'status' => 'Unauthorized', 'message' => 'Api Authorization Needed!'], 401);
    }
}
