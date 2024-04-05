<?php

namespace App\Http\Controllers\Api;

use App\Enums\ProductType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductDetailResource;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function paginate(Request $request) {
        $pageSize = $request->pageSize ?? 8;
        $products = Product::withNeededProductCardData()->addSalePrice();
        $type = $request->type;
        $acceptable_types = [ProductType::BEST_SELLER, ProductType::NEW_ARRIVAL, ProductType::ON_SALE];
        $sortable_fields = ['created_at', 'sales', 'sale_price'];
        $direction = $request->direction ?? 'asc';
        if (in_array($type, $acceptable_types)) {
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
        $sortBy = $request->sortBy;
        if ($sortBy && in_array($sortBy, $sortable_fields)) {
            $products->orderBy($sortBy, $direction);
        }
        if ($request->categories || $request->category) {
            if ($request->categories) {
                $products->filterByProductChildCategory($request->categories);
            } else {
                $products->filterByProductParentCategory($request->category);
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

    public function search(Request $request) {
        $search = $request->search ?? null;
        $type = $request->type;
        $products = Product::available();
        $pageSize = $request->pageSize ?? 10;
        if ($search) {
            $products->search('products.name', $search);
        }
        $acceptable_types = [ProductType::BEST_SELLER, ProductType::NEW_ARRIVAL, ProductType::ON_SALE];
        if (in_array($type, $acceptable_types)) {
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

    public function details(string $slug) {
        $product = Product::with('inventories.image')->whereSlug($slug)->firstOrFail();
        return new ProductDetailResource($product);
    }

    public function relatedProducts(Request $request, string $slug) {
        $product = Product::whereSlug($slug)->firstOrFail();
        $pageSize = $request->pageSize ?? 4;
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->with(['category', 'inventories' => function ($q) {
                return $q->available()->with(['image', 'attributes' => function ($q) {
                    $q->orderBy('attribute_inventory.created_at', 'desc');
                }]);
            }])
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id')->toArray());
            })->orderBy('created_at', 'desc')->paginate($pageSize);
        $paginateData = $relatedProducts->toArray();
        return BaseResponse::success([
            'items' => ProductResource::collection($relatedProducts),
            'total' => $paginateData['total'],
            'next_page' => $paginateData['next_page_url'],
            'prev_page' => $paginateData['prev_page_url'],
        ]);
    }
}
