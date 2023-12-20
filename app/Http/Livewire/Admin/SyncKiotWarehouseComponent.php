<?php

namespace App\Http\Livewire\Admin;

use App\Models\Inventory;
use App\Models\KiotProduct;
use App\Models\Product;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\ProductResource;

class SyncKiotWarehouseComponent extends Component
{
    public $percentage;

    protected $listeners = ['startSyncKiot' => 'sync', 'downloadKiotProduct' => 'downloadKiotData'];

    public function render()
    {
        return view('livewire.admin.sync-kiot-warehouse-component');
    }

    public function sync()
    {
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
    public function downloadKiotData()
    {
        KiotProduct::whereNotNull('id')->delete();
        $productResource = new ProductResource(App::make(Client::class));
        $data = $productResource->list(['pageSize' => '1']);
        $total = $data->getTotal();
        $numbeOfPage = $total % 100 == 0 ? $total / 100 : (int) ($total / 100) + 1;
        for ($i = 0; $i < $numbeOfPage; $i++) {
            $currentItem = $i * 100;
            $products = $productResource->list(['pageSize' => 100, 'currentItem' => $currentItem, 'includeInventory' => true])->getItems();
            foreach ($products as $product) {
                KiotProduct::updateOrCreate([
                    'kiot_product_id' => $product->getId(),
                    'kiot_code' => $product->getCode()
                ], [
                    'data' => $product->getModelData()
                ]);
            }
        }
        $skus = KiotProduct::pluck('kiot_code')->toArray();
        Inventory::whereNotIn('sku', $skus)->update(['stock_quantity' => 0]);
        $this->dispatchBrowserEvent('startSyncKiot');
    }
}
