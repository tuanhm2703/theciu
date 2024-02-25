<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\KiotProduct;
use App\Models\Product;
use App\Services\KiotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use VienThuong\KiotVietClient\WebhookType;

class WarehouseWebhookController extends Controller
{
    public function __construct(private KiotService $kiotService) {
    }
    public function updateKiotProduct(Request $request)
    {
        try {
            $data = $request->Notifications[0];
            $type = $data['Action'];
            if(str_contains($type, WebhookType::STOCK_UPDATE) || str_contains($type, WebhookType::PRODUCT_DELETE)) {
                $this->kiotService->syncWarehouseThroughWebhook($request);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
        return response()->json([
            'message' => 'Success'
        ]);
    }
}
