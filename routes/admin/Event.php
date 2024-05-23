<?php

use App\Http\Controllers\Admin\EventController;

Route::group(['prefix' => 'event', 'as' => 'event.'], function() {
    Route::get('paginate', [EventController::class, 'paginate'])->name('paginate');
    Route::get('product/paginate', [EventController::class, 'paginateProduct'])->name('product.paginate');
});
Route::resource('event', EventController::class);
