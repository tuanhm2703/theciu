<?php

use App\Http\Controllers\Admin\SeoManagementController;

Route::group(['prefix' => 'seo', 'as' => 'seo.'], function() {
    Route::get('/', [SeoManagementController::class, 'index'])->name('index');
    Route::put('/update', [SeoManagementController::class, 'update'])->name('update');
});
