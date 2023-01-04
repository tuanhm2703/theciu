<?php

use App\Http\Controllers\Admin\UserProfileController;

Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
