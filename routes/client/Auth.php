<?php

use App\Http\Controllers\Client\AuthController;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::get('facebook', [AuthController::class, 'redirectToProvider'])->name('facebook.login');
    Route::get('facebook/callback', [AuthController::class, 'handleProviderCallback'])->name('facebook.callback');
    Route::get('google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
});
