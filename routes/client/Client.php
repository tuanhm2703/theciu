<?php

Route::group(['as' => 'client.'], function() {
    include('Home.php');
    include('product/Product.php');
    include('blog/Blog.php');
    include('Auth.php');
    include('auth/Auth.php');
    include('page/Page.php');
});
