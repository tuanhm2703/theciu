<?php

use App\Http\Controllers\Api\JdController;

Route::group(['prefix' => 'jds'], function() {
    Route::get('', [JdController::class, 'index']);
    Route::get('/department-groups', [JdController::class, 'getDepartmentGroup']);
    Route::get('/{slug}', [JdController::class, 'detail']);
    Route::post('/{slug}/resumes', [JdController::class, 'postResume']);
    Route::get('/{slug}/related', [JdController::class, 'relatedJobs']);
});
