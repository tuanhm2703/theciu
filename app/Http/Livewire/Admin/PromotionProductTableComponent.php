<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;

class PromotionProductTableComponent extends Component
{
    public $products;


    public function render()
    {
        return view('livewire.admin.promotion-product-table-component');
    }

    public function addProducts($ids) {
        $products = Product::whereIn('id', $ids)->with('inventories')->get();
    }
}
