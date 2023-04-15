<?php

use App\Http\Controllers\Admin\CustomerController;

Route::group(['prefix' => 'customer', 'as' => 'customer.'], function() {
    Route::get('/paginate', [CustomerController::class, 'paginate'])->name('paginate');
});
Route::resource('customer', CustomerController::class);
