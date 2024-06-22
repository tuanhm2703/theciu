<?php

namespace App\Http\Services\SMSService;

use App\Http\Services\SMSService\Exceptions\ZNSException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ZaloZNSService {
    private $base_endpoint;
    private $client;
    public function __construct() {
        $this->base_endpoint = ZaloZNSEndpoint::BASE_ENDPOINT;
        $this->client = new Client([
            'base_uri' => $this->base_endpoint,
            'headers' => [
                'Content-type' => 'application/json',
                'Token' => config('services.zns.token')
            ],
        ]);
    }

    public function sendOtp(string $phone, string $otp) {
        try {
            $response = $this->client->post(ZaloZNSEndpoint::SEND_OTP, [
                'body' => json_encode([
                    'contactNumber' => $phone,
                    'otp' => $otp
                ])
            ]);
        } catch (ClientException $th) {
            \Log::error($th->getResponse()->getBody());
            throw new ZNSException("Gửi Otp không thành công, vui lòng thử lại sau");
        }
        $data = json_decode($response->getBody()->getContents());

        if($data->error) {
            \Log::error($th);
            throw new ZNSException("Gửi Otp không thành công, vui lòng thử lại sau");
        }
    }
}
