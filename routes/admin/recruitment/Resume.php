<?php

use App\Http\Controllers\Admin\ResumeController;

Route::group(['prefix' => 'resume', 'as' => 'resume.'], function() {
    Route::get('', [ResumeController::class, 'index'])->name('index');
    Route::get('/{resume}/pdf', [ResumeController::class, 'pdf'])->name('answer');
    Route::get('/{resume}/answer', [ResumeController::class, 'showAnswer'])->name('pdf');
    Route::get('/paginate', [ResumeController::class, 'paginate'])->name('paginate');
});
