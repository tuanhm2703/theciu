<?php

use App\Http\Controllers\Admin\WebsiteController;

Route::group(['prefix' => 'website', 'as' => 'website.'], function () {
    Route::get('/', [WebsiteController::class, 'index'])->name('index');
    Route::put('/update', [WebsiteController::class, 'update'])->name('update');
});
