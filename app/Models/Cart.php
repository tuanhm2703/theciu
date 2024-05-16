<?php

namespace App\Models;

use App\Http\Services\Shipping\Models\PackageInfo;
use App\Traits\Common\Addressable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
    use HasFactory, Addressable;

    protected $fillable = [
        'customer_id'
    ];

    public function inventories() {
        return $this->belongsToMany(Inventory::class, 'cart_items')->whereHas('product')->withPivot('quantity');
    }

    public function calculateSessionComboDiscount($item_selected) {
        if(count($item_selected) == 0) return collect([]);
        // inventory that selected in cart
        $inventories = $this->inventories->whereIn('id', $item_selected);
        // product that selected in cart
        $product_ids = array_unique($inventories->pluck('product_id')->toArray());
        /* The code is querying the `Combo` model to retrieve combos that do not have certain products. */
        $combos = Combo::whereDoesntHave('products', function($q) use ($product_ids) {
            $q->whereNotIn('products.id', $product_ids);
        })->with('products')->available()->get();
        $discounted_combos = [];
        $used_inventories = [];
        foreach($combos as $combo) {
            $total = 0;
            $c = [
                'discount_amount' => 0,
                'total_combo' => 0
            ];
            do {
                $total = 0;
                foreach($combo->products as $product) {
                    $inventory = $inventories->where('product_id', $product->id)->first();
                    if($inventory && $inventory->order_item->quantity > 0) {
                        $total += $inventory->price - $inventory->promotion_price;
                        $inventory->order_item->quantity--;
                        $used_inventories[$inventory->id] = isset($used_inventories[$inventory->id]) ? $used_inventories[$inventory->id]++ : 1;
                    } else {
                        $total = 0;
                        break;
                    }
                }
                if($total > 0) {
                    $c['discount_amount'] += $total;
                    $c['total_combo'] += 1;
                }
            } while ($total > 0);
            if($c['discount_amount'] > 0) {
                $c['combo'] = $combo;
                $discounted_combos[] = $c;
            }
        }
        foreach($inventories as $inventory) {
            if(isset($used_inventories[$inventory->id])) {
                $inventory->order_item->quantity += $used_inventories[$inventory->id];
            }
        }
        return collect($discounted_combos);
    }

    public function calculateComboDiscount($item_selected) {
        if(count($item_selected) == 0) return collect([]);
        // inventory that selected in cart
        $inventories = $this->inventories()->whereIn('inventories.id', $item_selected)->get();
        // product that selected in cart
        $product_ids = array_unique($inventories->pluck('product_id')->toArray());
        /* The code is querying the `Combo` model to retrieve combos that do not have certain products. */
        $combos = Combo::whereDoesntHave('products', function($q) use ($product_ids) {
            $q->whereNotIn('products.id', $product_ids);
        })->with('products')->available()->get();
        $discounted_combos = [];
        foreach($combos as $combo) {
            $total = 0;
            $c = [
                'discount_amount' => 0,
                'total_combo' => 0
            ];
            do {
                $total = 0;
                foreach($combo->products as $product) {
                    $inventory = $inventories->where('product_id', $product->id)->first();
                    if($inventory && $inventory->pivot?->quantity > 0) {
                        $total += $inventory->price - $inventory->promotion_price;
                        $inventory->pivot->quantity--;
                    } else {
                        $total = 0;
                        break;
                    }
                }
                if($total > 0) {
                    $c['discount_amount'] += $total;
                    $c['total_combo'] += 1;
                }
            } while ($total > 0);
            if($c['discount_amount'] > 0) {
                $c['combo'] = $combo;
                $discounted_combos[] = $c;
            }
        }
        return collect($discounted_combos);
    }
    public function getTotalWithBasePriceItems($item_selected) {
        if(count($item_selected) == 0) return 0;
        $total = 0;
        foreach ($this->inventories as $i) {
            /* Checking if the item is selected or not. If it is selected, it will add the price to the
            total. */
            if (in_array($i->id, $item_selected)) {
                $total += $i->price * $i->cart_stock;
            }
        }
        return $total;
    }
    public function getTotalWithSelectedItems($item_selected, $voucher = null) {
        if(count($item_selected) == 0) return 0;
        $total = 0;
        foreach ($this->inventories as $i) {
            /* Checking if the item is selected or not. If it is selected, it will add the price to the
            total. */
            if (in_array($i->id, $item_selected)) {
                $total += $i->sale_price * $i->cart_stock;
            }
        }
        if($voucher) {
            $total = $total - $voucher->getDiscountAmount($total);
        }
        return $total;
    }

    public function total() {
        $total = 0;
        foreach ($this->inventories as $i) {
            $total += $i->sale_price * (customer() ? $i->pivot->quantity : $i->order_item->quantity);
        }
        return $total;
    }


    public function getFormattedTotalAttribute() {
        return number_format($this->total(), 0, ',', '.');
    }

    public function getTotalQuantityAttribute() {
        return $this->inventories->sum('pivot.quantity');
    }

    public function getPackageInfoAttribute() {
        $package_info = new PackageInfo(0, 0, 0, 0);
        foreach ($this->inventories as $inventory) {
            $package_info->height += $inventory->package_info->height;
            $package_info->weight += $inventory->package_info->weight;
            $package_info->length = $inventory->package_info->length;
            $package_info->width = $inventory->package_info->width;
        }
        return $package_info;
    }

    public function getTotalAttribute() {
        return $this->total();
    }

    public function getPackageInfoBySelectedItems($ids) {
        $package_info = new PackageInfo(0, 0, 0, 0);
        foreach ($this->inventories as $inventory) {
            if (in_array($inventory->id, $ids)) {
                $package_info->height += $inventory->package_info->height * $inventory->cart_stock;
                $package_info->weight += $inventory->package_info->weight * $inventory->cart_stock;
                $package_info->length = $inventory->package_info->length;
                $package_info->width = $inventory->package_info->width;
            }
        }
        return $package_info;
    }
}
