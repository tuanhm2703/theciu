<?php

use App\Http\Controllers\Client\AddressController;

Route::group(['prefix' => 'address', 'as' => 'address.'], function() {
    Route::get('view/change', [AddressController::class, 'viewChangeAddressWithOutLogin'])->name('view.change');
    Route::delete('{id}', [AddressController::class, 'destroy'])->name('destroy');
});
