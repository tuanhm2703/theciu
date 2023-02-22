<?php

use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\RoleController;

Route::group(['prefix' => 'role', 'as' => 'role.'], function() {
    Route::get('paginate', [RoleController::class, 'paginate'])->name('paginate');
});


Route::resource('role', RoleController::class);
