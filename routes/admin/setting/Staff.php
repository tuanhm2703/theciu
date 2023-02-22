<?php

use App\Http\Controllers\Admin\StaffController;


Route::group(['prefix' => 'staff', 'as' => 'staff.'], function() {
    Route::get('paginate', [StaffController::class, 'paginate'])->name('paginate');
});

Route::resource('staff', StaffController::class);

