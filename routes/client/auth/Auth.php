<?php

use App\Http\Controllers\Client\Auth\AuthController;

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'middleware' => ['phoneVerification', 'auth:customer']], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    include('Profile.php');
    include('Cart.php');
    include('Review.php');
});
