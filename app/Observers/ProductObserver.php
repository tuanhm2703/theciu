<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    public function creating(Product $product) {
        if($product->code == null) {
            $product->migrateUniqueCode();
        }
        $product->slug = Str::snake(stripVN($product->name), '-');
    }


    public function updating(Product $product) {
        if($product->isDirty('name')) {
            $product->slug = Str::snake(stripVN($product->name), '-');
        }
    }
}
