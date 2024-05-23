<?php

use App\Http\Controllers\Admin\EventController;

Route::group(['prefix' => 'event', 'as' => 'event.'], function() {
    Route::get('paginate', [EventController::class, 'paginate'])->name('paginate');
});
Route::resource('event', EventController::class);
