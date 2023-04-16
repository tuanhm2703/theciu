<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Limit title meta tag length
    |--------------------------------------------------------------------------
    |
    | To best SEO implementation, limit tags.
    |
    */

    'title_limit' => 70,

    /*
    |--------------------------------------------------------------------------
    | Limit description meta tag length
    |--------------------------------------------------------------------------
    |
    | To best SEO implementation, limit tags.
    |
    */

    'description_limit' => 200,

    /*
    |--------------------------------------------------------------------------
    | Limit image meta tag quantity
    |--------------------------------------------------------------------------
    |
    | To best SEO implementation, limit tags.
    |
    */

    'image_limit' => 5,

    /*
    |--------------------------------------------------------------------------
    | Available Tag formats
    |--------------------------------------------------------------------------
    |
    | A list of tags formats to print with each definition
    |
    */

    'tags' => ['Tag', 'MetaName', 'MetaProperty', 'MetaProduct', 'TwitterCard'],

    /*
    |--------------------------------------------------------------------------
    | Strings Separator
    |--------------------------------------------------------------------------
    |
    | Use this string to separate default and custom title.
    |
    */

    'separator' => ' - ',
    'default_description' => 'Thời trang nữ THE CIU mang phong cách trẻ trung, năng động. Chuyên sản phẩm kết hợp đi học, đi chơi như áo thun, áo khoác, quần jean, đầm, chân váy.',
    'default_image' => '/img/theciu-meta.png',
    'default_title' => env('APP_NAME')
];
