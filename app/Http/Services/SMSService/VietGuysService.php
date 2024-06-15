<?php

namespace App\Http\Services\SMSService;

use App\Exceptions\Api\OtpException;
use App\Models\Setting;
use GuzzleHttp\Client;

class VietGuysService {
    private $refresh_access_token;
    private Client $client;
    private string $access_token;
    private string $username;
    private string $brand_name;
    public function __construct() {
        $this->client = new Client([
            'base_uri' => ApiEndPoint::BASE_ENDPOINT,
            'headers' => [
                'Content-type' => 'application/json'
            ]
        ]);
        $this->refresh_access_token = app()->get('VietGuysRefreshToken');
        $this->access_token = app()->get('VietGuysAccessToken');
        $this->username = app()->get('VietGuysUsername');
        $this->brand_name = app()->get('VietGuysBrandName');
    }

    public function sendOtp(string $phone, string $otp, string $time) {
        $data = [
            'u' => $this->username,
            'pwd' => $this->access_token,
            'from' => $this->brand_name,
            'phone' => $phone,
            'sms' => "THE C.I.U: Ma xac thuc cua ban la $otp. Tuyet doi khong chia se duoi bat ky hinh thuc nao. Ma xac thuc co hieu luc trong $time",
            'bid' => random_string(50),
            'type' => 0
        ];
        $response = $this->client->post(ApiEndPoint::SMS_BASE_URL . ApiEndPoint::SEND_SMS, [
            'body' => json_encode($data)
        ]);
        $response_data = json_decode(strval($response->getBody()));
        if ($this->checkSmsError($response) && $response_data->error_code === VietGuysSMSErrorCode::INCORRECT_CREDENTIALS) {
            $this->getAccessToken();
            $data['pwd'] = $this->access_token;
            $response = $this->client->post(ApiEndPoint::SMS_BASE_URL . ApiEndPoint::SEND_SMS, [
                'body' => json_encode($data)
            ]);
            $this->checkSmsError($response, true);
        }
    }

    private function get(string $uri, array $options = []) {
        $response = $this->client->get($uri, $options);
        if (str_contains($uri, ApiEndPoint::SMS_BASE_URL)) {
            if ($this->checkSmsError($response)) {
                $this->getAccessToken();
                $response = $this->client->get($uri, $options);
                $this->checkSmsError($response, true);
                return $response;
            }
        }
        return $response;
    }

    private function post(string $uri, array $options = []) {
        $response = $this->client->post($uri, $options);
        if (str_contains($uri, ApiEndPoint::SMS_BASE_URL)) {
            if ($this->checkSmsError($response)) {
                $this->getAccessToken();
                $response = $this->client->post($uri, $options);
                $this->checkSmsError($response, true);
                return $response;
            }
        }
        return $response;
    }

    public function getAccessToken() {
        $response = $this->client->post(ApiEndPoint::GENERATE_ACCESS_TOKEN, [
            'headers' => [
                'Refresh-token' => $this->refresh_access_token,
            ],
            'body' => json_encode([
                "username" => $this->username,
                "type" => "refresh_token"
            ])
        ]);
        $data = json_decode($response->getBody()->getContents())->data;
        $this->access_token = $data->access_token;
        $this->refresh_access_token = $data->refresh_token;
        Setting::updateVietGuysAfterRefresh($data->access_token, $data->refresh_token);
    }

    private function checkSmsError($response, $throwException = false) {
        $data = json_decode(strval($response->getBody()));
        if ($data->error === 1) {
            if ($throwException) {
                dd('hello');
                throw new OtpException($data->log);
            }
            return true;
        }
        return false;
    }
}
