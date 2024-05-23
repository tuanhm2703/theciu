<?php

use App\Http\Controllers\Api\BranchController;

Route::group(['prefix' => 'branches', 'as' => 'branch.'], function() {
    Route::get('/', [BranchController::class, 'all']);
});
