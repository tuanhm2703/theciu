<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;

class SyncKiotWarehouseComponent extends Component {
    public $percentage;

    protected $listeners = ['startSyncKiot' => 'sync'];

    public function render() {
        return view('livewire.admin.sync-kiot-warehouse-component');
    }

    public function sync() {
        $this->percentage = 0;

        while ($this->percentage < 100) {
            $this->percentage += 10;
            $this->emit('percentage', $this->percentage);

            // wait for one second
            sleep(1);
        }
        // $products = Product::whereNotNull('sku')->get();
        // foreach ($products as $index => $product) {
        //     $index = $index + 1;
        //     try {
        //         $product->syncKiotWarehouse();
        //     } catch (\Throwable $th) {
        //         //throw $th;
        //     }
        //     $this->percentage = (int) round($index / $products->count() * 100, 0);
        //     \Log::info($this->percentage);
        // }
    }
    // public function updatePercentage($index, $total) {
    //     $this->percentage = (int) round($index / $total * 100, 1);
    // }
}
