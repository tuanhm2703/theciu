<?php

use App\Http\Controllers\Client\Auth\AuthController;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    include('Profile.php');
    include('Cart.php');
});
