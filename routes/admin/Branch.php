<?php

use App\Http\Controllers\Admin\BranchController;

Route::group(['prefix' => 'branch', 'as' => 'branch.'], function() {
    Route::get('paginate', [BranchController::class, 'paginate'])->name('paginate');
});
Route::resource('branch', BranchController::class);
