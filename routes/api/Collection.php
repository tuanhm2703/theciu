<?php

use App\Http\Controllers\Api\CollectionController;

Route::group(['prefix' => 'collections', 'as' => 'collection.'], function () {
    Route::get('/paginate', [CollectionController::class, 'paginate']);
    Route::get('/{slug}', [CollectionController::class, 'details']);
    Route::get('/{slug}/related', [CollectionController::class, 'related']);
});
