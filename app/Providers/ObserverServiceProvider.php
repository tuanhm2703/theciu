<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Jd;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Voucher;
use App\Observers\AddressObserver;
use App\Observers\BlogObserver;
use App\Observers\CategoryObserver;
use App\Observers\EditByObserver;
use App\Observers\ImageObserver;
use App\Observers\InventoryObserver;
use App\Observers\JdObserver;
use App\Observers\OrderObserver;
use App\Observers\PageObserver;
use App\Observers\ProductObserver;
use App\Observers\PromotionObserver;
use App\Observers\VoucherObserver;
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
        Inventory::observe(InventoryObserver::class);
        Blog::observe(EditByObserver::class);
        Blog::observe(BlogObserver::class);
        Category::observe(CategoryObserver::class);
        Promotion::observe(PromotionObserver::class);
        Address::observe(AddressObserver::class);
        Order::observe(OrderObserver::class);
        Page::observe(PageObserver::class);
        Voucher::observe(VoucherObserver::class);
        Image::observe(ImageObserver::class);
        Jd::observe(JdObserver::class);
    }
}
