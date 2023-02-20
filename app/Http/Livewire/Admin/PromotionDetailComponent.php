<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class PromotionDetailComponent extends Component {
    public $selected_products;

    public $products;

    public $promotion;

    public function mounted() {
        $this->selected_products = $this->selected_products ? $this->selected_products : new Collection();
        $this->products = Product::whereIn('id', $this->selected_products->pluck('id')->toArray())->dontHavePromotion()->with('inventories', 'image')->get();
    }
    public function render() {
        return view('livewire.admin.promotion-detail-component');
    }
}
