<?php

use App\Http\Controllers\Admin\Ajax\ModuleController;

Route::group(['prefix' => 'module', 'as' => 'module.'], function () {
    Route::get('/{module}/permissions', [ModuleController::class, 'getPermissions'])->name('permission');
});
