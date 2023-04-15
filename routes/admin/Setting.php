<?php

Route::group(['prefix' => 'setting', 'as' => 'setting.'], function() {
    include('setting/Address.php');
    include('setting/Seo.php');
    include('setting/Warehouse.php');
    include('setting/Staff.php');
    include('setting/Shop.php');
    include('setting/Website.php');
});
