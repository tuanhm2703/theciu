<?php

use App\Http\Controllers\Admin\PageController;

Route::group(['prefix' => 'page', 'as' => 'page.'], function() {
    // Route::get('/', [PageController::class, 'index'])
});
Route::resource('page', PageController::class);
