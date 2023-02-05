<?php

Route::group(['prefix' => 'setting', 'as' => 'setting.'], function() {
    include('setting/Address.php');
    include('setting/Seo.php');
});
