<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\Config\ConfigService;
use App\Models\PaymentMethod;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function __construct(private ConfigService $configservice)
    {

    }

    public function getGeneralConfig() {
        $customer_keywords = requestUser() ? explode(',', requestUser()->search_keywords) : [];
        $payment_methods = PaymentMethod::active()->with('image:imageable_id,path')->get();
        return BaseResponse::success([
            'customer_keywords' => $customer_keywords,
            'trending_keywords' => $this->configservice->getTrendingKeywords(),
            'payment_methods' => $payment_methods
        ]);
    }
}
