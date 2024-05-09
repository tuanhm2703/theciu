<?php

namespace App\Http\Services\SMSService;

use GuzzleHttp\Client;

class VietGuysService {
    private $refresh_access_token = "1NQYUt_LhTufG8twChs0caXvh1MwFOO9WpbEK4xnisK6iUedtphradjjWSUk9HAZy6MpgbUVzE3obilLp";
    private Client $client;
    private string $access_token = 'NPYpVFrzwki9x0vwWwg03bSPJVqUTcmT9gUbB5x46K2KZk28ZhCkipWzqeZYK2f-RB2_nBVu1WoZVJOCWrPOCxW7slfjqTDl6BcCd7RphzYooulI7ZHYw2yJQoUlDDVD3M2eA5Amk0qAVXMnF15_gA';
    public function __construct() {
        $this->client = new Client([
            'base_uri' => ApiEndPoint::BASE_ENDPOINT,
            'headers' => [
                'Content-type' => 'application/json'
            ]
        ]);
    }

    public function getAccessToken(): string {
        $response = $this->client->post(ApiEndPoint::GENERATE_ACCESS_TOKEN, [
            'headers' => [
                'Refresh-token' => $this->refresh_access_token,
            ],
            'body' => json_encode([
                "username" => "theciu.kiotviet.com",
                "type" => "refresh_token"
            ])
        ]);
        return $response->getBody()->getContents();
    }
}
