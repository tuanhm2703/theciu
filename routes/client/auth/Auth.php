<?php

use App\Http\Controllers\Client\Auth\AuthController;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    include('Cart.php');
    Route::group(['middleware' => ['phoneVerification', 'auth:customer']], function() {
        include('Profile.php');
        include('Review.php');
    });
});
