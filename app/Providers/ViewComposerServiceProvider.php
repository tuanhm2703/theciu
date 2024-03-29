<?php

namespace App\Providers;

use App\Enums\CategoryType;
use App\Enums\PromotionType;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Combo;
use App\Models\Page;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        View::composer(
            'landingpage.layouts.pages.blog.components.detail.category_list',
            function ($view) {
                $categories = Category::whereHas('blogs', function ($q) {
                    $q->available();
                })->withCount('blogs')->orderBy('blogs_count', 'desc')->get();
                $view->with(['categories' => $categories]);
            }
        );

        View::composer(
            'landingpage.layouts.pages.blog.components.detail.popular_blogs',
            function ($view) {
                $blog = isset($view->getData()['blog']) ? $view->getData()['blog'] : null;
                $popular_blogs = Blog::available()->orderBy('created_at', 'desc')->with('image', 'categories')->limit(4);
                if ($blog) {
                    $popular_blogs->where('id', '!=', $blog->id);
                }
                $popular_blogs = $popular_blogs->limit(4)->get();
                $view->with(['popular_blogs' => $popular_blogs]);
            }
        );

        View::composer(
            'landingpage.layouts.app',
            function ($view) {
                $product_categories = App::get('ProductCategory');
                $new_arrival_categories = Category::with('image:imageable_id,path')->whereType(CategoryType::TRENDING)->get();
                $promotions = Promotion::haveNotEnded()->whereHas('products')->with(['products' => function ($q) {
                    $q->withNeededProductCardData();
                }])->where('type', '!=', PromotionType::ACCOM_GIFT)->get();
                $available_combos = Combo::available()->get();
                $best_seller_categories = Category::with("image:imageable_id,path")->whereType(CategoryType::BEST_SELLER)->whereHas('products')->get();
                $blog_categories = Category::allActiveBlogCategories();
                $view->with([
                    'available_combos' => $available_combos,
                    'product_categories' => $product_categories,
                    'new_arrival_categories' => $new_arrival_categories,
                    'promotions' => $promotions,
                    'blog_categories' => $blog_categories,
                    'best_seller_categories' => $best_seller_categories,
                ]);
            }
        );

        View::composer(
            'landingpage.layouts.components.navs.cart',
            function ($view) {
                $cart = null;
                if (auth('customer')->check()) {
                    $customer = auth('customer')->user();
                    $cart = Cart::with(['inventories' => function ($q) {
                        return $q->with('image:path,imageable_id', 'product:id,slug,name');
                    }])->firstOrCreate([
                        'customer_id' => $customer->id
                    ]);
                }
                $view->with(['cart' => $cart]);
            }
        );

        View::composer(
            'landingpage.layouts.pages.cart.index',
            function ($view) {
                $cart = null;
                if (auth('customer')->check()) {
                    $customer = auth('customer')->user();
                    $cart = Cart::with(['inventories' => function ($q) {
                        return $q->with('image:path,imageable_id', 'product:id,slug,name');
                    }])->firstOrCreate([
                        'customer_id' => $customer->id
                    ]);
                }
                $view->with(['cart' => $cart]);
            }
        );

        View::composer('landingpage.layouts.meta', function ($view) {
            $keywords = Category::whereType(CategoryType::PRODUCT)->pluck('name')->toArray();
            $mKeywords = implode(', ', $keywords);
            $view->with(['mKeywords' => $mKeywords]);
        });
    }
}
