<?php

namespace App\Models;

use App\Enums\CategoryType;
use App\Enums\MediaType;
use App\Enums\PromotionStatusType;
use App\Enums\PromotionType;
use App\Enums\StatusType;
use App\Exceptions\InventoryOutOfStockException;
use App\Http\Services\Shipping\Models\PackageInfo;
use App\Traits\Common\CommonFunc;
use App\Traits\Common\Imageable;
use App\Traits\Common\Wishlistable;
use App\Traits\Scopes\CustomScope;
use App\Traits\Scopes\ProductScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\SchemaOrg\AggregateRating;
use Spatie\SchemaOrg\Brand;
use Spatie\SchemaOrg\BreadcrumbList;
use Spatie\SchemaOrg\Offer;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Collection\InventoryCollection;
use VienThuong\KiotVietClient\Resource\ProductResource;
use Meta;
use Spatie\SchemaOrg\ListItem;
use Spatie\SchemaOrg\Schema;

class Product extends Model {
    use HasFactory, SoftDeletes, Imageable, CustomScope, ProductScope, CommonFunc, Wishlistable;

    protected $fillable = [
        'name',
        'description',
        'model',
        'material',
        'style',
        'slug',
        'type',
        'weight',
        'height',
        'length',
        'width',
        'is_reorder',
        'condition',
        'sku',
        'short_description',
        'additional_information',
        'shipping_and_return',
        'code',
        'reorder_days',
        'status',
        'visible'
    ];

    public function getImageSizesAttribute() {
        return [
            600,
            1000
        ];
    }
    const DEFAULT_IMAGE_SIZE = 1000;

    public function unique_attribute_inventories() {
        return $this->inventories()->leftJoin('attribute_inventory', function ($q) {
            $q->on('attribute_inventory.inventory_id', 'inventories.id');
        })->where('attribute_inventory.order', 1)->groupBy('attribute_inventory.value', 'inventories.product_id');
    }



    public function inventories() {
        return $this->hasMany(Inventory::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')->withPivot([
            'total',
            'quantity',
            'origin_price',
            'promotion_price',
            'title',
            'name',
            'is_reorder'
        ]);
    }

    public function inventory() {
        return $this->hasOne(Inventory::class);
    }

    public function size_rule_image() {
        return $this->morphOne(Image::class, 'imageable')->where('type', MediaType::SIZE_RULE);
    }

    public function size_rule_images() {
        return $this->morphMany(Image::class, 'imageable')->where('type', MediaType::SIZE_RULE);
    }

    public function images() {
        return $this->morphMany(Image::class, 'imageable')->where(function ($q) {
            $q->where('type', MediaType::IMAGE)->orWhere('type', null);
        })->orderBy('order');
    }
    public function image() {
        return $this->morphOne(Image::class, 'imageable')->where(function ($q) {
            $q->where('type', MediaType::IMAGE)->orWhere('type', null);
        })->orderBy('order');
    }
    public function category() {
        return $this->hasOneThrough(Category::class, Categorizable::class, 'categorizable_id', 'id', 'id', 'category_id')->where(function ($q) {
            $q->where('type', CategoryType::PRODUCT)->orWhere('type', null);
        })
            ->where('categorizable_type', $this->getMorphClass());
    }
    public function categories() {
        return $this->morphToMany(Category::class, 'categorizable')->where('type', CategoryType::PRODUCT);
    }

    public function other_categories() {
        return $this->morphToMany(Category::class, 'categorizable')->where('type', '!=', CategoryType::PRODUCT);
    }

    public function promotions() {
        return $this->belongsToMany(Promotion::class, 'promotion_product')->withPivot([
            'promotion_id',
            'product_id',
            'featured'
        ]);
    }
    public function combos() {
        return $this->belongsToMany(Combo::class, 'combo_product');
    }

    public function available_promotions() {
        return $this->belongsToMany(Promotion::class, 'promotion_product')->available();
    }
    public function available_promotion() {
        return $this->hasOneThrough(Promotion::class, PromotionProduct::class, 'product_id', 'id', 'id', 'promotion_id')->available();
    }

    public function available_combos() {
        return $this->belongsToMany(Combo::class, 'combo_product')->available();
    }
    public function available_combo() {
        return $this->hasOneThrough(Combo::class, ComboProduct::class, 'product_id', 'id', 'id', 'combo_id')->available()->latest();
    }

    public function flash_sales() {
        return $this->belongsToMany(Promotion::class, 'promotion_product')->where('promotions.type', PromotionType::FLASH_SALE);
    }

    public function flash_sale() {
        return $this->hasOneThrough(Promotion::class, PromotionProduct::class, 'product_id', 'id', 'id', 'promotion_id')->where(function ($q) {
            $q->where('type', PromotionType::FLASH_SALE);
        })->latest();
    }

    public function available_flash_sales() {
        return $this->belongsToMany(Promotion::class, 'promotion_product')->where('promotions.type', PromotionType::FLASH_SALE)->available();
    }

    public function migrateUniqueCode() {
        return $this->code = uniqid(config('app.prefix_uniqid'));
    }

    /**
     * > Get the minimum sale price of all the inventories of a product
     *
     * @return The lowest price of the product.
     */
    public function getSalePriceAttribute() {
        return $this->is_has_sale ? $this->promotion_price : $this->original_price;
    }

    public function getDetailLinkAttrubute() {
        return route('client.product.details', $this->slug);
    }

    public function getPageTitleAttribute() {
        return $this->categories->first()->name . " - " . $this->name;
    }

    public function getPromotionPriceAttribute() {
        $price = INF;
        foreach ($this->inventories as $inventory) {
            if ($inventory->has_promotion && $inventory->stock_quantity > 0) {
                $price = $price > $inventory->sale_price ? $inventory->sale_price : $price;
            }
        }
        return $price == INF ? null : $price;
    }

    public function getOriginalPriceAttribute() {
        $maxPrice = 0;
        foreach ($this->inventories as $inventory) {
            $maxPrice = $inventory->price > $maxPrice ? $inventory->price : $maxPrice;
        }
        return $maxPrice;
    }

    public function getSnakeNameAttribute() {
        return Str::snake($this->name);
    }

    public function getIsHasSaleAttribute() {
        return $this->available_promotion && $this->promotion_price != null && $this->promotion_price != $this->original_price;
    }

    public function getPromotionAttribute() {
        if ($this->relationLoaded('promotions')) {
            return $this->promotions->first();
        } else {
            return $this->promotions()->first();
        }
    }

    public function getDiscountPercentAttribute() {
        return (int) ($this->sale_price - $this->original_price) / $this->original_price * 100;
    }

    /**
     * If the relation is loaded, return the sum of the stock_quantity column of the inventories table.
     * If the relation is not loaded, return the sum of the stock_quantity column of the inventories
     * table
     *
     * @return The total stock quantity of all the inventories of the product.
     */
    public function getTotalStockQuantityAttribute() {
        if ($this->relationLoaded('inventories')) return $this->inventories->sum('stock_quantity');
        return $this->inventories()->sum('stock_quantity');
    }

    public function getPromotionStatusAttribute() {
        $status = PromotionStatusType::STOPPED;
        if ($this->promotion && $this->promotion->from && $this->promotion->to) {
            if (now()->isBetween($this->promotion->from, $this->promotion->to)) {
                $status = PromotionStatusType::HAPPENDING;
            } else if (now()->isBefore($this->promotion->from)) {
                $status = PromotionStatusType::COMMING;
            } else {
                $status = PromotionStatusType::STOPPED;
            }
        }
        if (in_array($status, [PromotionStatusType::COMMING, PromotionStatusType::HAPPENDING]) && optional($this->promotion)->isInactive()) {
            return PromotionStatusType::PAUSE;
        }
        return $status;
    }

    public function getPromotionStatusLabelAttribute() {
        switch ($this->promotion_status) {
            case PromotionStatusType::COMMING:
                return "Sắp diễn ra";
            case PromotionStatusType::HAPPENDING:
                return "Đang diễn ra";
            case PromotionStatusType::STOPPED:
                return "Đã kết thúc";
            case PromotionStatusType::PAUSE:
                return "Tạm dừng";
            default:
                return "Đã kết thúc";
        }
    }

    public function getPackageInfoAttribute() {
        return new PackageInfo($this->weight, $this->length, $this->height, $this->width);
    }

    public function getIsOnCustomerWishlistAttribute() {
        return in_array($this->id, customerWishlist());
    }

    public function getMetaTags() {
        $keywords = $this->categories()->pluck('name')->toArray();
        $keywords[] = $this->name;
        $Keywords[] = getAppName();
        $link = $this->detail_link;
        Meta::remove('image');
        Meta::set('description', $this->short_description);
        Meta::set('keywords', implode(', ', $keywords));
        Meta::set('title', $this->page_title);
        Meta::set('image', $this->image->path_with_domain);
        Meta::set('url', $link);
        Meta::set('product', [
            'price' => $this->sale_price,
            'currency' => 'VND'
        ]);
        Meta::set('o:availablility', $this->inventories()->sum('stock_quantity'));
    }
    public function getSchemaOrg() {
        $schemas = [];
        try {
            $reviewScore = Review::whereHas('order', function($q) {
                $q->whereHas('products', function($q) {
                    $q->where('products.id', $this->id);
                });
            })->average('product_score');
            $reviewCount = $this->orders()->whereHas('review')->count();
            $schema = Schema::product()->description($this->short_description)->sku($this->slug)
            ->name($this->name)
            ->image($this->images->pluck('path_with_domain')->toArray())->brand((new Brand())
            ->name(getAppName()))
            ->offers([
                (new Offer())->price($this->sale_price)->priceCurrency('VND')->url($this->detail_link)
            ]);
            if($reviewScore > 0) {
                $schema->aggregateRating((new AggregateRating())
                ->reviewCount($reviewCount)
                ->ratingValue($reviewScore));
            }
            $schemas[] = $schema->toScript();
            $schemas[] = Schema::breadcrumbList()->itemListElement([
                (new ListItem)->position(1)->item(Schema::thing()->setProperty('@id', route('client.home'))->setProperty('name', getAppName())),
                (new ListItem)->position(1)->item(Schema::thing()->setProperty('@id', route('client.product.index'))->setProperty('name', 'Danh sách sản phẩm')),
                (new ListItem)->position(1)->item(Schema::thing()->setProperty('@id', $this->detail_link)->setProperty('name', $this->name))
            ])->toScript();
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
        }
        return $schemas;
    }

    public function putKiotWarehouse($decrease = true) {
        $productResource = new ProductResource(App::make(Client::class));
        $kiotSetting = App::get('KiotConfig');
        if ($kiotSetting->data['branchId']) {
            $client = App::make(Client::class);
            $productResource = new ProductResource($client);
            try {
                $product = $productResource->getByCode($this->sku);
            } catch (\Throwable $th) {
                Log::error($th);
                return;
            }
            $inventories = $product->getInventories()->getItems();
            foreach ($inventories as $inventory) {
                if ($inventory->getBranchId() == $kiotSetting->data['branchId']) {
                    $quantity = $decrease ? $inventory->getOnHand() - 1 : $inventory->getOnHand() + 1;
                    if ($quantity < 0) {
                        throw new InventoryOutOfStockException();
                    }
                    $inventory->setOnHand($quantity);
                }
            }
            $product->setInventories(new InventoryCollection($inventories));
            $productResource->update($product);
        }
    }
    public function generateUniqueSlug() {
        $base_slug = stripVN($this->name);
        $slug = $base_slug;
        while(Product::withTrashed()->where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = "$base_slug-".now()->timestamp;
        }
        return $slug;
    }
}
