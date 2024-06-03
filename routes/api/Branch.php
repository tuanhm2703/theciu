<?php

use App\Http\Controllers\Api\BranchController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'branches', 'as' => 'branch.'], function () {
    Route::get('/', [BranchController::class, 'all']);
});
