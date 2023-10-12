<?php

use App\Http\Controllers\Api\JdController;

Route::group(['prefix' => 'jds'], function() {
    Route::get('', [JdController::class, 'index']);
    Route::get('/{jd}', [JdController::class, 'detail']);
    Route::post('/{jd}/resumes', [JdController::class, 'postResume']);
});
