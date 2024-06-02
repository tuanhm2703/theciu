<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CollectionResource;
use App\Http\Resources\Api\CustomerWishlistResource;
use App\Models\Category;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class CollectionController extends Controller {
    public function getWishlist(Request $request) {
        $user = request()->user();
        $pageSize = $request->pageSize ?? 10;
        $collection_ids = $user->query_wishlist(Category::class)->pluck('wishlistable_id')->toArray();
        $collections = Category::active()->whereType(CategoryType::COLLECTION)->with('image')->orderBy('order')->whereIn('categories.id', $collection_ids)->paginate($pageSize);
        $paginateData = $collections->toArray();
        return BaseResponse::success([
            'items' => CollectionResource::collection($collections),
            'total' => $paginateData['total'],
            'next_page' => $paginateData['next_page_url'],
            'prev_page' => $paginateData['prev_page_url'],
        ]);
    }
    public function addToWishlist(string $slug, Request $request) {
        $collection = Category::whereSlug($slug)->firstOrFail();
        $user = $request->user();
        if (!$user->query_wishlist(Category::class)->where('wishlistable_id', $collection->id)->exists()) {
            $collection->addToWishlist($user->id);
        }
        return BaseResponse::success(new CustomerWishlistResource($user));
    }

    public function removeFromWishlist(string $slug, Request $request) {
        $collection = Category::whereSlug($slug)->firstOrFail();
        $user = $request->user();
        if (!$user->query_wishlist(Category::class)->where('wishlistable_id', $collection->id)->exists()) {
            $collection->removeFromCustomerWishlist($user->id);
        }
        return BaseResponse::success(new CustomerWishlistResource($user));
    }
}
