<?php

use App\Http\Controllers\Api\SeoController;
use App\Http\Controllers\Client\BranchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('branches', [BranchController::class, 'ajaxGetBranches']);
Route::group(['prefix' => 'seo'], function() {
    Route::get('product-xlsx', [SeoController::class, 'getProductExcelFile']);
});
