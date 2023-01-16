<?php

namespace App\Exceptions;

use App\Models\Inventory;
use Exception;

class InventoryOutOfStockException extends Exception {
    public function updated(Inventory $inventory) {
        if($inventory->stock_quantity < 0) {
            throw new InventoryOutOfStockException("Sản phẩm $inventory->name không đủ số lượng", 409);
        }
    }
}
