<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\Config\ConfigService;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function __construct(private ConfigService $configservice)
    {

    }

    public function getGeneralConfig() {
        $customer_keywords = auth('api')->check() ? requestUser()->search_keywords : [];
        return BaseResponse::success([
            'customer_keywords' => $customer_keywords,
            'trending_keywords' => $this->configservice->getTrendingKeywords(),
        ]);
    }
}
