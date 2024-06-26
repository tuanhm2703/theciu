<?php

namespace App\Http\Services\ShopeeService;

use App\Models\Product;
use App\Models\Setting;
use App\Models\ShopeeProduct;
use Haistar\ShopeePhpSdk\client\ShopeeApiConfig;
use Haistar\ShopeePhpSdk\request\shop\ShopApiClient;

class ShopeeService {
    private $shopeeClient;
    private $apiConfig;
    private $partnerId;
    private $partnerKey;
    private $refreshToken;
    private $accessToken;
    private $shopId;
    public function __construct() {
        $this->shopeeClient = new ShopApiClient();
        $this->apiConfig = new ShopeeApiConfig();
        $this->partnerId = intval(app()->get('ShopeeConfig')['partnerId']);
        $this->partnerKey = app()->get('ShopeeConfig')['partnerKey'];
        $this->accessToken = app()->get('ShopeeAccessToken');
        $this->refreshToken = app()->get('ShopeeRefreshToken');
        $this->shopId = app()->get('ShopeeShopId');
        $this->apiConfig->setPartnerId($this->partnerId);
        $this->apiConfig->setShopId($this->shopId);
        $this->apiConfig->setAccessToken($this->accessToken);
        $this->apiConfig->setSecretKey($this->partnerKey);
    }
    public function updateAccessToken($code, $mainAccountId) {
        $host = ShopeeEndPoint::BASE_ENDPOINT;
        $path = ShopeeEndPoint::GET_TOKEN;
        $path = "/api/v2/auth/token/get";
        $timest = time();
        $mainAccountId = intval($mainAccountId);
        $partnerId = $this->partnerId;
        $partnerKey = $this->partnerKey;
        $body = array("code" => $code,  "main_account_id" => $mainAccountId, "partner_id" => $partnerId);
        $baseString = sprintf("%s%s%s", $partnerId, $path, $timest);

        $sign = hash_hmac('sha256', $baseString, $partnerKey);
        $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $host, $path, $partnerId, $timest, $sign);

        $c = curl_init($url);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($c);

        $ret = json_decode($result, true);
        $this->accessToken = $ret["access_token"];
        $this->refreshToken = $ret["refresh_token"];
        $this->shopId = $ret['shop_id_list'][0];
        $this->updateShopId($this->shopId);
        $this->updateShopeeAccessToken($this->accessToken);
        $this->updateShopeeRefreshToken($this->refreshToken);
    }

    public function refreshToken() {
        $host = ShopeeEndPoint::BASE_ENDPOINT;
        $path = ShopeeEndPoint::REFRESH_TOKEN;
        $this->reloadRefreshToken();
        $body = array("partner_id" => $this->partnerId, "shop_id" => $this->shopId, "refresh_token" => $this->refreshToken);
        $timest = time();
        $baseString = sprintf("%s%s%s", $this->partnerId, $path, $timest);
        $sign = hash_hmac('sha256', $baseString, $this->partnerKey);
        $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $host, $path, $this->partnerId, $timest, $sign);

        $c = curl_init($url);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($c);
        $ret = json_decode($result);
        $this->updateShopeeAccessToken($ret->access_token);
        $this->updateShopeeRefreshToken($ret->refresh_token);
        return $ret;
    }

    private function updateShopId($shopId) {
        $this->shopId = $shopId;
        Setting::updateOrCreate(
            ['name' => 'shopee_shop_id'],
            [
                'data' => $shopId
            ]
        );
    }
    private function updateShopeeAccessToken($access_token) {
        $this->accessToken = $access_token;
        Setting::updateOrCreate(
            ['name' => 'shopee_access_token'],
            [
                'data' => $access_token
            ]
        );
    }
    private function updateShopeeRefreshToken($refresh_access_token) {
        $this->refreshToken = $refresh_access_token;
        Setting::updateOrCreate(
            ['name' => 'shopee_refresh_token'],
            [
                'data' => $refresh_access_token
            ]
        );
    }

    public function getItemList($offset = 0, $pageSize = 50, $status = 'NORMAL') {
        $baseUrl = ShopeeEndPoint::BASE_ENDPOINT;
        $apiPath = ShopeeEndPoint::GET_ITEM_LIST;

        $params = [
            'offset' => $offset,
            'page_size' => $pageSize,
            'item_status' => $status
        ];
        $productList = $this->get($baseUrl, $apiPath, $params, $this->apiConfig);
        return $productList;
    }

    public function syncShopeeProduct() {
        $baseUrl = ShopeeEndPoint::BASE_ENDPOINT;
        $apiPath = ShopeeEndPoint::GET_ITEM_LIST;

        $params = [
            'offset' => 0,
            'page_size' => 50,
            'item_status' => "NORMAL"
        ];
        $productList = $this->get($baseUrl, $apiPath, $params, $this->apiConfig);
        while ($productList->response->has_next_page) {
            $ids = collect($productList->response->item)->pluck('item_id')->toArray();
            $apiPath = ShopeeEndPoint::GET_ITEM_BASE_INFO;
            $params1 = [
                'item_id_list' => implode(",", $ids),
            ];
            $baseInfo = $this->get($baseUrl, $apiPath, $params1, $this->apiConfig);
            foreach ($baseInfo->response->item_list as $item) {
                ShopeeProduct::updateOrCreate([
                    'shopee_product_id' => $item->item_id
                ], [
                    'name' => $item->item_name,
                    'data' => $item,
                    'product_id' => Product::whereName($item->item_name)->first()?->id
                ]);
            }
            $params['offset'] += 50;
            $apiPath = "/api/v2/product/get_item_list";
            $productList = $this->get($baseUrl, $apiPath, $params, $this->apiConfig);
        }
    }

    public function syncShopeeProductByIds(array $ids) {
        $baseUrl = ShopeeEndPoint::BASE_ENDPOINT;
        $apiPath = ShopeeEndPoint::GET_ITEM_BASE_INFO;
        $params1 = [
            'item_id_list' => implode(",", $ids),
        ];
        $baseInfo = $this->get($baseUrl, $apiPath, $params1, $this->apiConfig);
        foreach ($baseInfo->response->item_list as $item) {
            ShopeeProduct::updateOrCreate([
                'shopee_product_id' => $item->item_id
            ], [
                'name' => $item->item_name,
                'data' => $item,
                'product_id' => Product::whereName($item->item_name)->first()?->id
            ]);
        }
    }

    public function getShopeeProductComment($cursor, $pageSize) {
        $baseUrl = ShopeeEndPoint::BASE_ENDPOINT;
        $apiPath = ShopeeEndPoint::GET_PRODUCT_COMMENT;

        $params = [
            'cursor' => $cursor,
            'page_size' => $pageSize,
        ];
        return $this->get($baseUrl, $apiPath, $params, $this->apiConfig);
    }
    public function getListOrder() {
        $baseUrl = ShopeeEndPoint::BASE_ENDPOINT;
        $apiPath = ShopeeEndPoint::GET_ORDER_LIST;

        $params = [
            'time_range_field' => 'create_time',
            'time_from' => now()->yesterday()->timestamp,
            'time_to' => now()->timestamp,
            'page_size' => 100,
            'order_status' => 'COMPLETED'
        ];
        return $this->get($baseUrl, $apiPath, $params, $this->apiConfig);
    }
    public function getOrderDetailByIds($order_ids) {
        $baseUrl = ShopeeEndPoint::BASE_ENDPOINT;
        $apiPath = ShopeeEndPoint::GET_ORDER_DETAILS;

        $params = [
            'order_sn_list' => implode(',', $order_ids),
            'response_optional_fields' => 'item_list'
        ];
        return $this->get($baseUrl, $apiPath, $params, $this->apiConfig);
    }

    private function get($baseUrl, $apiPath, $params, ShopeeApiConfig $apiConfig) {
        $response = $this->shopeeClient->httpCallGet($baseUrl, $apiPath, $params, $this->apiConfig);
        if(isset($response->error) && $response->error === 'error_auth') {
            $this->refreshToken();
            return $this->shopeeClient->httpCallGet($baseUrl, $apiPath, $params, $this->apiConfig);
        }
        return $response;
    }

    private function reloadRefreshToken() {
        $this->refreshToken = Setting::getShopeeRefreshToken()->data;
    }
}
