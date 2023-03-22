<?php

namespace App\Http\Livewire\Client;

use App\Models\Product;
use Livewire\Component;

class ProductDetailInfoComponent extends Component
{
    public $product;

    public $inventory_images;

    protected $listeners = ['changeProduct' => 'changeProduct'];

    public function mount()
    {
        if ($this->product) {
            $this->inventory_images = collect();
            foreach ($this->product->inventories as $inventory) {
                if ($inventory->image) {
                    $this->inventory_images->push($inventory->image);
                }
            }
            $this->inventory_images->unique('name');
        }
    }

    public function render()
    {
        return view('livewire.client.product-detail-info-component');
    }

    public function changeProduct($id)
    {
        if(auth('customer')->check()) {
            $this->inventory_images = $this->inventory_images ?? collect();
            $this->product = Product::with(['category', 'inventories' => function ($q) {
                return $q->available()->with(['image', 'attributes' => function ($q) {
                    $q->orderBy('attribute_inventory.created_at', 'desc');
                }]);
            }])->find($id);
            foreach ($this->product->inventories->where('stock_quantity', '>', 0) as $inventory) {
                if ($inventory->image) {
                    $this->inventory_images->push($inventory->image);
                }
            }
            $this->inventory_images->unique('name');
            $this->emit('product-pick:changeProduct', $this->product);
        } else {
            $this->dispatchBrowserEvent('openLoginForm');
        }
    }
}
