<?php

use App\Http\Controllers\Admin\OrderController;

Route::group(['prefix' => 'order', 'as' => 'order.'], function() {
});

Route::resource('order', OrderController::class);
