<?php

namespace App\Http\Services\ShopeeService;

use App\Models\Setting;
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
        $code = '41745a6b4f7544614750426b67637161';
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
        Setting::updateOrCreate(
            ['name' => 'shopee_shop_id'],
            [
                'data' => $shopId
            ]
        );
    }
    private function updateShopeeAccessToken($access_token) {
        Setting::updateOrCreate(
            ['name' => 'shopee_access_token'],
            [
                'data' => $access_token
            ]
        );
    }
    private function updateShopeeRefreshToken($refresh_access_token) {
        Setting::updateOrCreate(
            ['name' => 'shopee_refresh_token'],
            [
                'data' => $refresh_access_token
            ]
        );
    }
}
