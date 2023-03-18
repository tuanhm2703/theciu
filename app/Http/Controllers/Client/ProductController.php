<?php

namespace App\Http\Controllers\Client;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function details($slug) {
        $product = Product::findBySlug($slug)->with(['category', 'inventories' => function ($q) {
            return $q->available()->with(['image', 'attributes' => function ($q) {
                $q->orderBy('attribute_inventory.created_at', 'desc');
            }]);
        }])->firstOrFail();
        $other_products = Product::where('id', '!=', $product->id)
            ->with(['category', 'inventories' => function ($q) {
                return $q->available()->with(['image', 'attributes' => function ($q) {
                    $q->orderBy('attribute_inventory.created_at', 'desc');
                }]);
            }])
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id')->toArray());
            })->limit(8)->orderBy('created_at', 'desc')->get();
        return view('landingpage.layouts.pages.product.detail.index', compact('product', 'other_products'));
    }

    public function index(Request $request) {
        $title = trans('labels.product_list');
        return view('landingpage.layouts.pages.product.index', compact('title'));
    }

    public function saleOff($slug = null) {
        $title = trans('labels.promotion');
        $promotion = null;
        if($slug) {
            $promotion = Promotion::whereSlug($slug)->firstOrFail();
            $title = $promotion->name;
        }
        $haspromotion = true;
        return view('landingpage.layouts.pages.product.index', compact('promotion', 'title', 'haspromotion'));
    }
    public function bestSeller() {
        $categoryType = CategoryType::BEST_SELLER;
        $title = trans('labels.best_seller');
        return view('landingpage.layouts.pages.product.best-seller.index', compact('categoryType', 'title'));
    }
    public function myWishlist() {
        return view('landingpage.layouts.pages.product.wishlist.index');
    }

    public function newArrival() {
        $categoryType = CategoryType::NEW_ARRIVAL;
        $title = trans('labels.new_arrival');
        return view('landingpage.layouts.pages.product.new-arrival.index', compact('categoryType', 'title'));
    }
}
