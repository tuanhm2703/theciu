<?php

namespace App\Models;

use App\Enums\StatusType;
use App\Traits\Common\Imageable;
use App\Traits\Scopes\CustomScope;
use App\Traits\Scopes\InventoryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\ProductResource;

class Inventory extends Model
{
    use HasFactory, SoftDeletes, Imageable, InventoryScope, CustomScope;
    protected $fillable = [
        'product_id',
        'stock_quantity',
        'sku',
        'price',
        'promotion_price',
        'promotion_from',
        'promotion_to',
        'promotion_status',
        'status',
        'total_promotion_quantity',
        'promotion_quantity',
        'quantity_each_order',
    ];

    protected $casts = [
        'promotion_from' => 'datetime',
        'promotion_to' => 'datetime'
    ];

    protected $appends = [
        'has_promotion',
        'formatted_price'
    ];

    public function getImageSizesAttribute()
    {
        return [
            100,
            30,
            1000
        ];
    }
    const DEFAULT_IMAGE_SIZE = 1000;

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->orderBy('attribute_inventory.created_at')->withPivot('value')->withTimestamps();
    }

    public function firstAttribute()
    {
        return $this->hasOneThrough(Attribute::class, AttributeInventory::class, 'inventory_id', 'id', null, 'attribute_id')
            ->where('attribute_inventory.order', 1)->groupBy('laravel_through_key');
    }
    public function secondAttribute()
    {
        return $this->hasOneThrough(Attribute::class, AttributeInventory::class, 'inventory_id', 'id', null, 'attribute_id')
            ->where('attribute_inventory.order', 2)->groupBy('laravel_through_key');
    }
    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function order_item()
    {
        return $this->hasOne(OrderItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }
    public function getCartStockAttribute()
    {
        if ($this->pivot) return $this->pivot->quantity;
        return $this->order_item?->quantity ?? 1;
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_product', 'product_id', null, 'product_id')->orderBy('created_at', 'desc');
    }

    /**
     * If the current date is between the promotion_from and promotion_to dates, then return true
     *
     * @return A boolean value.
     */
    public function getHasPromotionAttribute()
    {
        return now()->isBetween($this->promotion_from, $this->promotion_to);
    }

    /**
     * > If the attributes relation is not loaded, load it, then return a comma separated list of the
     * values of the attributes
     *
     * @return String A string of the attributes of the product.
     */
    public function getTitleAttribute(): String
    {
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
    public function getSalePriceAttribute()
    {
        if ($this->has_promotion && $this->promotion_status === 1) return $this->promotion_price;
        return $this->price;
    }

    public function getFormattedSalePriceAttribute()
    {
        return format_currency_with_label($this->sale_price);
    }

    public function getPackageInfoAttribute()
    {
        return $this->product->package_info;
    }

    public function getNameAttribute()
    {
        return $this->product->name . " - " . $this->title;
    }

    public function decreaseQuantity()
    {
        $this->update([
            'stock_quantity' => DB::raw('stock_quantity - 1')
        ]);
    }

    public function increaseQuantity()
    {
        $this->update([
            'stock_quantity' => DB::raw('stock_quantity + 1')
        ]);
    }

    public function syncKiotWarehouse()
    {
        $productSource = new ProductResource(App::make(Client::class));
        $kiotSetting = App::get('KiotConfig');
        if ($kiotSetting->data['branchId']) {
            try {
                $kiotProduct = $productSource->getByCode($this->sku);
                $inventories = $kiotProduct->getInventories();
                foreach ($inventories as $inventory) {
                    if ($inventory->getBranchId() == $kiotSetting->data['branchId']) {
                        $otherProperties = $inventory->getOtherProperties();
                        $stock_quantity = $inventory->getOnHand() - $inventory->getReserved();
                        $this->update([
                            'stock_quantity' => $stock_quantity < 0 ? 0 : $stock_quantity,
                            'status' => $otherProperties['isActive']
                        ]);
                    }
                }
            } catch (\Throwable $th) {
                \Log::error($th);
                $this->update([
                    'status' => StatusType::INACTIVE
                ]);
                return;
            }
        }
    }

    public function syncKiotWarehouseLocal()
    {
        $kiotSetting = App::get('KiotConfig');
        if ($kiotSetting->data['branchId']) {
            try {
                $kiotProduct = KiotProduct::where('kiot_code', $this->sku)->first();
                if ($kiotProduct) {
                    $inventories = $kiotProduct->data['inventories'];
                    foreach ($inventories as $inventory) {
                        if ($inventory['branchId'] == $kiotSetting->data['branchId']) {
                            $otherProperties = $inventory['otherProperties'];
                            $stock_quantity = $inventory['onHand'] - $inventory['reserved'];
                            $this->update([
                                'stock_quantity' => $stock_quantity < 0 ? 0 : $stock_quantity,
                                'status' => $otherProperties['isActive']
                            ]);
                        }
                    }
                } else {
                    $this->update(['status' => StatusType::INACTIVE]);
                }
            } catch (\Throwable $th) {
                \Log::error($th);
                $this->update([
                    'status' => StatusType::INACTIVE
                ]);
                return;
            }
        }
    }

    public function isOutOfStock()
    {
        return $this->stock_quantity <= 0;
    }
}
