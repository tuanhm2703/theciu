<?php

use App\Http\Controllers\Client\ReviewController;

Route::group(['prefix' => 'review', 'as' => 'review.'], function() {
    Route::post('/', [ReviewController::class, 'store'])->name('store');
    Route::put('/{review}/like', [ReviewController::class, 'like'])->name('like');
});
