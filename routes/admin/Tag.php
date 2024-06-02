<?php

use App\Http\Controllers\Admin\TagController;

Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
    Route::get('search', [TagController::class, 'search'])->name('search');
});
