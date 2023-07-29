<?php

Route::group(['as' => 'client.', 'middleware' => ['meta']], function() {
    include('Home.php');
    include('product/Product.php');
    include('blog/Blog.php');
    include('Auth.php');
    include('auth/Auth.php');
    include('page/Page.php');
});
