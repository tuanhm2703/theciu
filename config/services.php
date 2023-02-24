<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
    'kiotviet' => [
        'client_id' => env('KIOTVIET_CLIENT_ID'),
        'client_secret' => env('KIOTVIET_CLIENT_SECRET'),
        'retailer' => env('KIOTVIET_RETAILER')
    ],
    'vnpay' => [
        'tmn_code' => env('VNP_TMNCODE'),
        'hash_secret' => env('VNP_HASH_SECRET'),
        'url' => env('VNP_URL'),
        'refund_url' => env('VNP_REFUND_URL'),
        'ipn_url' => env('VNP_IPN_URL')
    ],
    'imgproxy' => [
        'key' => env('PROXY_KEY'),
        'salt' => env('PROXY_SALT'),
        'domain' => env('IMAGE_PROXY_DOMAIN')
    ]
];
