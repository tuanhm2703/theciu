<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function details($slug) {
        $product = Product::findBySlug($slug)->with(['category', 'inventories' => function ($q) {
            return $q->with(['image', 'attributes' => function ($q) {
                $q->orderBy('attribute_inventory.created_at', 'desc');
            }]);
        }])->firstOrFail();
        $other_products = Product::where('id', '!=', $product->id)
            ->with(['category', 'inventories' => function ($q) {
                return $q->with(['image', 'attributes' => function ($q) {
                    $q->orderBy('attribute_inventory.created_at', 'desc');
                }]);
            }])
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id')->toArray());
            })->limit(8)->orderBy('created_at', 'desc')->get();
        return view('landingpage.layouts.pages.product.detail.index', compact('product', 'other_products'));
    }

    public function index(Request $request) {
        return view('landingpage.layouts.pages.product.index');
    }

    public function saleOff() {
        return view('landingpage.layouts.pages.product.sale-off.index');
    }
    public function myWishlist() {
        return view('landingpage.layouts.pages.product.wishlist.index');
    }
}
