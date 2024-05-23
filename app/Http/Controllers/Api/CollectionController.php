<?php

namespace App\Http\Controllers\Api;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CollectionDetailResource;
use App\Http\Resources\Api\CollectionResource;
use App\Models\Category;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function paginate(Request $request) {
        $pageSize = $request->pageSize ?? 10;
        $collections = Category::active()->whereType(CategoryType::COLLECTION)->with('image')->orderBy('order')->paginate($pageSize);
        return BaseResponse::success(CollectionResource::collection($collections));
    }

    public function details(string $slug) {
        $collection = Category::whereSlug($slug)->with(['products' => function($q) {
            $q->withNeededProductCardData()->addSalePrice();
        }])->active()->first();
        return BaseResponse::success(new CollectionDetailResource($collection));
    }
}
