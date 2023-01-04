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
        $category = $request->category;
        $promotion = $request->promotion;
        $pageSize = $request->pageSize ?? 12;
        $products = Product::query();
        $title = null;
        $type = null;
        if ($category) {
            $category = Category::whereSlug($category)->with('categories.categories')->firstOrFail();
            $category_ids = $category->getAllChildId();
            $title = $category->name;
            $type = 'Danh mục';
            $products = Product::whereHas('categories', function($q) use ($category_ids) {
                return $q->whereIn('categories.id', $category_ids);
            });
        }
        if ($promotion) {
            $promotion = Promotion::whereSlug($promotion)->first();
            if ($promotion) {
                $promotion = $products->whereHas('promotions', function ($q) use ($promotion) {
                    $q->where('promotions.slug', $promotion->slug);
                })->firstOrFail();
                $title = $promotion->name;
                $type = 'Chương trình';
            }
        }
        $products = $products->select('products.name', 'products.slug', 'products.id')->with(['inventories.image:path,imageable_id', 'images:path,imageable_id'])->paginate($pageSize);
        return view('landingpage.layouts.pages.product.index', compact('products', 'category', 'title', 'type'));
    }
}
