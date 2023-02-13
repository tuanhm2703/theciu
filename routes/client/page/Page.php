<?php

use App\Http\Controllers\Client\PageController;

Route::group(['prefix' => 'page', 'as' => 'page.'], function() {
    Route::get('{slug}', [PageController::class, 'details'])->name('details');
});
