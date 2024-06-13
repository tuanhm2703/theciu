<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CustomerWishlistResource;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function getWishlist(Request $request) {
        $user = requestUser();
        $product_ids = $user->query_wishlist(Product::class)->pluck('wishlistable_id')->toArray();
        $pageSize = $request->pageSize ?? 10;
        $products = Product::withNeededProductCardData()->addSalePrice()->whereIn('products.id', $product_ids)->paginate($pageSize);
        $paginateData = $products->toArray();
        return BaseResponse::success([
            'items' => ProductResource::collection($products),
            'total' => $paginateData['total'],
            'next_page' => $paginateData['next_page_url'],
            'prev_page' => $paginateData['prev_page_url'],
        ]);
    }

    public function removeFromWishlist(string $slug) {
        $user = requestUser();
        $product = Product::whereSlug($slug)->firstOrFail();
        $product->removeFromCustomerWishlist($user->id);
        return BaseResponse::success(new CustomerWishlistResource($user));
    }

    public function addToWishlist(string $slug) {
        $user = requestUser();
        $product = Product::whereSlug($slug)->firstOrFail();
        if (!$user->query_wishlist(Product::class)->where('wishlistable_id', $product->id)->exists()) {
            $product->addToWishlist($user->id);
        }
        return BaseResponse::success(new CustomerWishlistResource($user));
    }
}
