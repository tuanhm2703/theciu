<?php

use App\Http\Controllers\Admin\Ajax\ModuleController;

Route::group(['prefix' => 'module', 'as' => 'module.'], function () {
    Route::get('/roles', [ModuleController::class, 'paginateRoles'])->name('role.paginate');
});
