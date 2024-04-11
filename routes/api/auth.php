<?php

use App\Http\Controllers\Api\Auth\AuthController as AuthAuthController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('facebook', [AuthController::class, 'redirectToProvider'])->name('facebook.login');
Route::get('facebook/callback', [AuthController::class, 'handleProviderCallback'])->name('facebook.callback');
Route::get('google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('logout', [AuthAuthController::class, 'logout']);
});
