<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhoneVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (auth()->user()->phone_verified_at == null) {
                toastr()->error('Please verify your phone number', 'Verify Phone Number');

                return redirect(route('error404'));
            }
        }

        return $next($request);
    }
}
