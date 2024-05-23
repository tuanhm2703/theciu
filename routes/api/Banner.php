<?php

use App\Http\Controllers\Api\BannerController;

Route::group(['prefix' => 'banners', 'as' => 'banner.'], function() {
    Route::get('/', [BannerController::class, 'getAll'])->name('all');
});
