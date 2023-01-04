<?php

Route::group(['prefix' => 'appearance', 'as' => 'appearance.'], function() {
    include('appearance/Banner.php');
    include('appearance/Blog.php');
});
