<?php

namespace App\Http\Controllers\Api;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CollectionDetailResource;
use App\Http\Resources\Api\CollectionResource;
use App\Models\Category;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class CollectionController extends Controller {
    public function paginate(Request $request) {
        $pageSize = $request->pageSize ?? 10;
        $collections = Category::active()->withCount('wishlists')->whereType(CategoryType::COLLECTION)->with('image')->orderBy('order')->paginate($pageSize);
        $paginateData = $collections->toArray();
        return BaseResponse::success([
            'items' => CollectionResource::collection($collections),
            'total' => $paginateData['total'],
            'next_page' => $paginateData['next_page_url'],
            'prev_page' => $paginateData['prev_page_url'],
        ]);
    }

    public function details(string $slug) {
        $collection = Category::whereSlug($slug)->with(['products' => function ($q) {
            $q->withNeededProductCardData()->addSalePrice();
        }])->withCount('wishlists')->active()->first();
        return BaseResponse::success(new CollectionDetailResource($collection));
    }

    public function related(string $slug, Request $request) {
        $pageSize = $request->pageSize ?? 10;
        $collection =  Category::whereSlug($slug)->firstOrFail();
        $collections = Category::related($collection)->active()->with('image')->orderBy('order')->paginate($pageSize);
        $paginateData = $collections->toArray();
        return BaseResponse::success([
            'items' => CollectionResource::collection($collections),
            'total' => $paginateData['total'],
            'next_page' => $paginateData['next_page_url'],
            'prev_page' => $paginateData['prev_page_url'],
        ]);
    }
}
