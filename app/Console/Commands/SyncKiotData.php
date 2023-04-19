<?php

namespace App\Console\Commands;

use App\Models\KiotCustomer;
use App\Models\KiotProduct;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\CustomerResource;
use VienThuong\KiotVietClient\Resource\ProductResource;

class SyncKiotData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kiot:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync kiot data: customer, product';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $this->syncKiotProduct();
        $this->syncKiotCustomer();
    }

    private function syncKiotProduct() {
        $productResource = new ProductResource(App::make(Client::class));
        $data = $productResource->list(['pageSize' => '1']);
        $total = $data->getTotal();
        $numbeOfPage = $total % 100 == 0 ? $total / 100 : (int) ($total / 100) + 1;
        $bar = $this->output->createProgressBar($total);
        for ($i=0; $i < $numbeOfPage; $i++) {
            $currentItem = $i * 100;
            $products = $productResource->list(['pageSize' => 100, 'currentItem' => $currentItem])->getItems();
            foreach($products as $product) {
                KiotProduct::updateOrCreate([
                    'kiot_product_id' => $product->getId(),
                    'kiot_code' => $product->getCode()
                ], [
                    'data' => $product->getModelData()
                ]);
                $bar->advance();
            }
        }
        $bar->finish();
    }
    private function syncKiotCustomer() {
        $customerResource = new CustomerResource(App::make(Client::class));
        $data = $customerResource->list(['pageSize' => '1']);
        $total = $data->getTotal();
        $numbeOfPage = $total % 100 == 0 ? $total / 100 : (int) ($total / 100) + 1;
        $bar = $this->output->createProgressBar($total);
        for ($i=0; $i < $numbeOfPage; $i++) {
            $currentItem = $i * 100;
            $customers = $customerResource->list(['pageSize' => 100, 'currentItem' => $currentItem, 'includeTotal' => true])->getItems();
            foreach($customers as $customer) {
                KiotCustomer::updateOrCreate([
                    'code' => $customer->getCode(),
                    'kiot_customer_id' => $customer->getId()
                ], [
                    'total_point' => $customer->getTotalPoint(),
                    'reward_point' => $customer->getRewardPoint(),
                ]);
                $bar->advance();
            }
        }
        $bar->finish();
    }
}
