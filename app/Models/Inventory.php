<?php

namespace App\Models;

use App\Traits\Common\Imageable;
use App\Traits\Scopes\InventoryScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Inventory extends Model {
    use HasFactory, SoftDeletes, Imageable, InventoryScope;

    protected $fillable = [
        'product_id',
        'stock_quantity',
        'sku',
        'price',
        'promotion_price',
        'promotion_from',
        'promotion_to',
        'promotion_status',
    ];

    protected $casts = [
        'promotion_from' => 'datetime',
        'promotion_to' => 'datetime'
    ];

    protected $appends = [
        'has_promotion',
        'formatted_price'
    ];

    public function attributes() {
        return $this->belongsToMany(Attribute::class)->withPivot('value');
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedPriceAttribute() {
        return number_format($this->price, 0, ',', '.');
    }

    public function promotions() {
        return $this->belongsToMany(Promotion::class, 'promotion_product', 'product_id', null, 'product_id')->orderBy('created_at', 'desc');
    }

    /**
     * If the current date is between the promotion_from and promotion_to dates, then return true
     *
     * @return A boolean value.
     */
    public function getHasPromotionAttribute() {
        $now = Carbon::now();
        return $now->isBetween($this->promotion_from, $this->promotion_to);
    }

    /**
     * > If the attributes relation is not loaded, load it, then return a comma separated list of the
     * values of the attributes
     *
     * @return String A string of the attributes of the product.
     */
    public function getTitleAttribute(): String {
        if (!$this->relationLoaded('attributes')) {
            $this->setRelation('attributes', $this->attributes()->get());
        }
        return implode(',', $this->getRelation('attributes')->pluck('pivot.value')->toArray());
    }

    /**
     * If the product has a promotion and the promotion is active, return the promotion price,
     * otherwise return the regular price
     *
     * @return Float The sale price of the product.
     */
    public function getSalePriceAttribute() {
        if($this->has_promotion && $this->promotion_status === 1) return $this->promotion_price;
        return $this->price;
    }
}
