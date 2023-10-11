<?php

Route::group(['prefix' => 'recruitment', 'as' => 'recruitment.'], function() {
    include('Jd.php');
    include('Resume.php');
});
