<?php

namespace App\Http\Services\ShopeeService;

class ShopeeEndPoint {
    const GET_TOKEN = '/api/v2/auth/token/get';
    const BASE_ENDPOINT = 'https://partner.shopeemobile.com';
    const REFRESH_TOKEN = "/api/v2/auth/access_token/get";
}
