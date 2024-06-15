<?php

namespace App\Http\Services\SMSService;

class ApiEndPoint {
    const GENERATE_ACCESS_TOKEN = 'token/v1/refresh';
    const BASE_ENDPOINT = "https://api-v2.vietguys.biz:4438";
    const SMS_BASE_URL = 'https://cloudsms4.vietguys.biz:4438';
    const SEND_SMS = '/api/index.php';
}
