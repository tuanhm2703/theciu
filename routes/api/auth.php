<?php

use App\Http\Controllers\Api\Auth\AuthController as AuthAuthController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/send-login-otp', [AuthController::class, 'sendLoginOtp']);
Route::post('/login-with-otp', [AuthController::class, 'loginWithOtp']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('facebook', [AuthController::class, 'redirectToProvider'])->name('facebook.login');
Route::get('facebook/callback', [AuthController::class, 'handleProviderCallback'])->name('facebook.callback');
Route::get('google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
Route::post('send-otp', [AuthController::class, 'sendVerifyOtp'])->name('sendVerifyOtp');
Route::post('verify-otp', [AuthController::class, 'verifyOtp'])->name('sendVerifyOtp');
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'auth', 'as' => 'auth.'], function () {
    include('auth/Profile.php');
    include('auth/Order.php');
    include('auth/Address.php');
    include('auth/Voucher.php');
});
