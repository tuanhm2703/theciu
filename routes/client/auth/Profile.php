<?php

use App\Http\Controllers\Client\Auth\ProfileController;

Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    include('Profile/Address.php');
});
