<?php

use App\Http\Controllers\Api\CollectionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'collections', 'as' => 'collection.'], function () {
    Route::get('/paginate', [CollectionController::class, 'paginate']);
    Route::get('/{slug}', [CollectionController::class, 'details']);
    Route::get('/{slug}/related', [CollectionController::class, 'related']);
});
