<?php

namespace App\Http\Controllers\Api;

use App\Enums\ProductType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function paginate(Request $request) {
        $pageSize = $request->pageSize ?? 8;
        $products = Product::withNeededProductCardData();
        $type = $request->type;
        $acceptable_types = [ProductType::BEST_SELLER, ProductType::NEW_ARRIVAL, ProductType::ON_SALE];
        if(in_array($type, $acceptable_types)) {
            switch ($type) {
                case ProductType::BEST_SELLER:
                    $products->bestSeller();
                    break;
                case ProductType::NEW_ARRIVAL:
                    $products->newArrival();
                    break;
                case ProductType::ON_SALE;
                    $products->hasAvailablePromotions();
                default:
                    break;
            }
        }
        $products = $products->paginate($pageSize);
        $paginateData = $products->toArray();
        return BaseResponse::success([
            'items' => ProductResource::collection($products),
            'total' => $paginateData['total'],
            'next_page' => $paginateData['next_page_url'],
            'prev_page' => $paginateData['prev_page_url'],
        ]);
    }
}
