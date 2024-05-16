<?php

namespace App\Http\Middleware;

use Auth;
use Cache;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class LastSeenStatusUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $expireTime = Carbon::now()->addMinutes(5);
            Cache::put('is_online'.Auth::user()->id, true, $expireTime);
            $user = auth()->user();
            $user->last_active_at = Carbon::now();
            $user->save();
        }

        return $next($request);
    }
}
