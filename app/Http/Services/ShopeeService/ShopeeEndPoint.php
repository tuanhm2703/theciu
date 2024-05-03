<?php

namespace App\Http\Services\ShopeeService;

class ShopeeEndPoint {
    const GET_TOKEN = '/api/v2/auth/token/get';
    const BASE_ENDPOINT = 'https://partner.shopeemobile.com';
    const REFRESH_TOKEN = "/api/v2/auth/access_token/get";
    const GET_ITEM_LIST = '/api/v2/product/get_item_list';
    const GET_ITEM_BASE_INFO = '/api/v2/product/get_item_base_info';
    const GET_PRODUCT_COMMENT = '/api/v2/product/get_comment';
    const GET_ORDER_DETAILS = '/api/v2/order/get_order_detail';
    const GET_ORDER_LIST = '/api/v2/order/get_order_list';
}
