<?php

use App\Http\Controllers\Admin\RankController;


Route::group(['prefix' => 'rank', 'as' => 'rank.'], function() {
    Route::get('paginate', [RankController::class, 'paginate'])->name('paginate');
});
Route::resource('rank', RankController::class);
