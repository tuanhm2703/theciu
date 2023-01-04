<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use App\Observers\BlogObserver;
use App\Observers\CategoryObserver;
use App\Observers\EditByObserver;
use App\Observers\ProductObserver;
use App\Observers\PromotionObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider {
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
        Product::observe(ProductObserver::class);
        Blog::observe(EditByObserver::class);
        Blog::observe(BlogObserver::class);
        Category::observe(CategoryObserver::class);
        Promotion::observe(PromotionObserver::class);
    }
}
