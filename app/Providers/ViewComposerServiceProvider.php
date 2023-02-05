<?php

namespace App\Providers;

use App\Enums\CategoryType;
use App\Enums\PromotionType;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
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
            'landingpage.layouts.pages.blog.components.detail.sidebar',
            function ($view) {
                $categories = Category::whereHas('blogs', function ($q) {
                    $q->available();
                })->withCount('blogs')->orderBy('blogs_count', 'desc')->get();
                $popular_blogs = Blog::available()->orderBy('created_at', 'desc')->with('image', 'categories')->limit(4)->get();
                $view->with(['categories' => $categories, 'popular_blogs' => $popular_blogs]);
            }
        );
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
                $blog = $view->getData()['blog'];
                $popular_blogs = Blog::available()->orderBy('created_at', 'desc')->with('image', 'categories')->limit(4);
                if ($blog) {
                    $popular_blogs->where('id', '!=', $blog->id);
                }
                $popular_blogs = $popular_blogs->limit(4)->get();
                $view->with(['popular_blogs' => $popular_blogs]);
            }
        );

        View::composer(
            'landingpage.layouts.components.header-bottom',
            function ($view) {
                $product_categories = Category::getMenuCategories();
                $shop_categories = Category::whereHas('products')->with('image:imageable_id,path')->whereType(CategoryType::SHOP)->get();
                $promotions = Promotion::available()->whereHas('products')->with(['products' => function ($q) {
                    $q->available()->with('image:path,imageable_id')->select('id', 'slug', 'name');
                }])->get();
                $blog_categories = Category::allActiveBlogCategories();
                $view->with(['product_categories' => $product_categories, 'shop_categories' => $shop_categories, 'promotions' => $promotions, 'blog_categories' => $blog_categories]);
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
            function($view) {
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
            'landingpage.layouts.pages.home.components.featured_category',
            function ($view) {
                $featured_categories = Category::whereHas('image')->where('type', CategoryType::FEATURED)->active()->get();
                $view->with(['featured_categories' => $featured_categories]);
            }
        );
        View::composer(
            'landingpage.layouts.pages.home.components.deal_of_day',
            function ($view) {
                $flash_sale_products = Product::available()->whereHas('flash_sales', function ($q) {
                    return $q->available();
                })->with('inventories.image', 'images:path,imageable_id', 'flash_sale')->select('products.id', 'products.name', 'products.slug')->get();
                $view->with(['flash_sale_products' => $flash_sale_products]);
            }
        );

        View::composer(
            'landingpage.layouts.components.banner-slider',
            function ($view) {
                $banners = Banner::active()->with('image')->orderBy('order', 'desc')->orderBy('updated_at', 'desc')->get();
                $view->with(['banners' => $banners]);
            }
        );

        View::composer(
            'landingpage.layouts.pages.home.components.trending',
            function ($view) {
                $trending_categories = Category::trending()->with(['products' => function ($q) {
                    $q->available()->with('images', 'inventories.image', 'categories')->select('products.id', 'products.name', 'slug')->groupBy('products.id');
                }])->active()->get();
                $view->with(['trending_categories' => $trending_categories]);
            }
        );

        View::composer(
            'landingpage.layouts.pages.home.components.new_arrival',
            function ($view) {
                $new_arrival_products = Product::available()->newArrival()
                    ->with('inventories', 'images:path,imageable_id')
                    ->select('products.id', 'products.name', 'products.slug')->get();
                $view->with(['new_arrival_products' => $new_arrival_products]);
            }
        );

        View::composer(
            'landingpage.layouts.pages.blog.components.detail.related_posts',
            function ($view) {
                $blog = $view->getData()['blog'];
                $related_blogs = Blog::whereHas('categories', function ($q) use ($blog) {
                    $q->whereIn('categories.id', $blog->categories->pluck('id')->toArray());
                })->with('image', 'categories')->where('blogs.id', '!=', $blog->id)->get();
                $view->with(['related_blogs' => $related_blogs]);
            }
        );
        View::composer('landingpage.layouts.meta', function($view) {
            $keywords = Category::whereType(CategoryType::PRODUCT)->pluck('name')->toArray();
            $mKeywords = implode(', ', $keywords);
            $view->with(['mKeywords' => $mKeywords]);
        });
    }
}
