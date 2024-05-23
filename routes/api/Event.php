<?php

use App\Http\Controllers\Api\EventController;

Route::group(['prefix' => 'events'], function() {
    Route::get('paginate', [EventController::class, 'paginate']);
    Route::get('{slug}', [EventController::class, 'details']);
    Route::get('{slug}/products', [EventController::class, 'getProducts']);
});
