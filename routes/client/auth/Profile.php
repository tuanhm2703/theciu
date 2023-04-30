<?php

use App\Http\Controllers\Client\Auth\ProfileController;

Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/password', [ProfileController::class, 'password'])->name('password');
    Route::get('/phone', [ProfileController::class, 'phone'])->name('phone');
    include('Profile/Address.php');
    include('Profile/Order.php');
});
