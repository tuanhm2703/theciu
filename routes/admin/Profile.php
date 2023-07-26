<?php

use App\Http\Controllers\Admin\UserProfileController;

Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
