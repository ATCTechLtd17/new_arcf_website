<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AuthAccountController;
use Illuminate\Support\Facades\Route;

Route::middleware(['disablePreventBack', 'htmlMinifier'])->group(static function () {
    Auth::routes(['login' => true, 'register' => false, 'reset' => false, 'verify' => false]);
    Route::get('/login', [AuthAccountController::class, 'showLoginForm'])->name('login');
    // Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showPage'])->name('password.showPage');
    Route::post('/password/code', [ForgotPasswordController::class, 'send'])->name('password.code');
    Route::get('/password/reset/code/{data}/{type}', [ForgotPasswordController::class, 'reset'])->name('password.reset.code');
    Route::post('/password/reset/code/confirm', [ForgotPasswordController::class, 'confirmAdmin'])->name('password.reset.code.confirm');
});
