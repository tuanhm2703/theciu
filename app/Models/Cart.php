<?php

namespace App\Models;

use App\Traits\Common\Addressable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
    use HasFactory, Addressable;

    protected $fillable = [
        'customer_id'
    ];

    public function inventories() {
        return $this->belongsToMany(Inventory::class, 'cart_items')->withPivot('quantity');
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
}
