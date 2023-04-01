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

    public function getTotalWithSelectedItems($item_selected, $voucher = null) {
        if(count($item_selected) == 0) return 0;
        $total = 0;
        foreach ($this->inventories as $i) {
            /* Checking if the item is selected or not. If it is selected, it will add the price to the
            total. */
            if (in_array($i->id, $item_selected)) {
                $total += $i->sale_price * $i->pivot->quantity;
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
            $total += $i->sale_price * $i->pivot->quantity;
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
                $package_info->height += $inventory->package_info->height * $inventory->pivot->quantity;
                $package_info->weight += $inventory->package_info->weight * $inventory->pivot->quantity;
                $package_info->length = $inventory->package_info->length;
                $package_info->width = $inventory->package_info->width;
            }
        }
        return $package_info;
    }
}
