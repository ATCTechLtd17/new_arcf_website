<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AuthAccountController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function profile()
    {
        return view('profile');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
