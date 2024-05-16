<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountActiveStatus
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
        if (Auth::check()) {
            if (!auth()->user()->is_active) {
                toastr()->error('Your account is inactive, please contact admin', 'Account InActive');
                return redirect(route('error404'));
            }
        }

        return $next($request);
    }
}
