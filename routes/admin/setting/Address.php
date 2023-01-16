<?php

use App\Http\Controllers\Admin\AddressController;


Route::group(['prefix' => 'address', 'as' => 'address.'], function() {
    // Route::get('/', [AddressController::class, 'index'])->name('index');
});
Route::resource('address', AddressController::class);
