<?php

use App\Http\Controllers\Admin\Ajax\OrderController;

Route::group(['prefix' => 'order', 'as' => 'order.'], function() {
    Route::get('paginate', [OrderController::class, 'paginate'])->name('paginate');
});
