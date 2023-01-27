<?php

namespace App\Models;

use App\Enums\CategoryType;
use App\Enums\MediaType;
use App\Enums\PromotionStatusType;
use App\Enums\PromotionType;
use App\Enums\StatusType;
use App\Http\Services\Shipping\Models\PackageInfo;
use App\Traits\Common\CommonFunc;
use App\Traits\Common\Imageable;
use App\Traits\Scopes\CustomScope;
use App\Traits\Scopes\ProductScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model {
    use HasFactory, SoftDeletes, Imageable, CustomScope, ProductScope, CommonFunc;

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
        'code'
    ];

    public function inventories() {
        return $this->hasMany(Inventory::class);
    }

    public function inventory() {
        return $this->hasOne(Inventory::class);
    }

    public function size_rule_image() {
        return $this->morphOne(Image::class, 'imageable')->where('type', MediaType::SIZE_RULE);
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

    public function promotions() {
        return $this->belongsToMany(Promotion::class, 'promotion_product');
    }

    public function flash_sales() {
        return $this->belongsToMany(Promotion::class, 'promotion_product')->where('promotions.type', PromotionType::FLASH_SALE);
    }

    public function flash_sale() {
        return $this->hasOneThrough(Promotion::class, PromotionProduct::class, 'product_id', 'id', 'id', 'promotion_id')->where(function ($q) {
            $q->where('type', PromotionType::FLASH_SALE);
        })->latest();
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

    public function getPromotionPriceAttribute() {
        $price = INF;
        foreach ($this->inventories as $inventory) {
            if ($inventory->has_promotion) {
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
        return $this->promotion_price != null && $this->promotion_price != $this->original_price;
    }

    public function getPromotionAttribute() {
        if ($this->relationLoaded('promotions')) {
            return $this->promotions->first();
        } else {
            return $this->promotions()->first();
        }
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
        if($this->promotion && $this->promotion->from && $this->promotion->to) {
            if(now()->isBetween($this->promotion->from, $this->promotion->to)) {
                $status = PromotionStatusType::HAPPENDING;
            } else if(now()->isBefore($this->promotion->from)) {
                $status = PromotionStatusType::COMMING;
            } else {
                $status = PromotionStatusType::STOPPED;
            }
        }
        if(in_array($status, [PromotionStatusType::COMMING, PromotionStatusType::HAPPENDING]) && optional($this->promotion)->isInactive()) {
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
}
