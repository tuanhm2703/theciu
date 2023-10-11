<?php

use App\Http\Controllers\Api\JdController;

Route::group(['prefix' => 'jd'], function() {
    Route::get('', [JdController::class, 'index']);
});
