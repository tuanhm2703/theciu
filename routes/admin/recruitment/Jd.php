<?php

use App\Http\Controllers\Admin\JDController;

Route::group(['prefix' => 'jd', 'as' => 'jd.'], function() {
    Route::get('/', [JDController::class, 'index'])->name('index');
    Route::get('/paginate', [JDController::class, 'paginate'])->name('paginate');
    Route::get('/create', [JDController::class, 'create'])->name('create');
    Route::post('', [JDController::class, 'store'])->name('store');
    Route::get('/{jd}/edit', [JDController::class, 'edit'])->name('edit');
    Route::put('/{jd}', [JDController::class, 'update'])->name('update');
    Route::get('/{jd}/resume', [JDController::class, 'viewResumeTable'])->name('resume.index');
    Route::delete('/{jd}', [JDController::class, 'destroy'])->name('destroy');
});
