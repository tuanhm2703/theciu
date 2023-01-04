<?php

use App\Http\Controllers\Client\BlogController;

Route::group(['prefix' => 'blog', 'as' => 'blog.'], function() {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'details'])->name('details');
});
