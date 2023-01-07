<?php

use App\Http\Controllers\Client\Auth\AddressController;

Route::group(['prefix' => 'address', 'as' => 'address.'], function() {
    Route::get('view/change', [AddressController::class, 'viewChangeAddress'])->name('view.change');
    Route::get('view/create', [AddressController::class, 'viewCreate'])->name('view.create');
});
Route::resource('address', AddressController::class);
