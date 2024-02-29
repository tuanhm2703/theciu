<?php

namespace App\Jobs\Kiot;

use App\Models\Customer;
use App\Services\KiotService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\CustomerResource;

class SyncKiotCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private $currentItem, private $pageSize)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $kiotService = new KiotService();
        $customerResource = new CustomerResource(App::make(Client::class));
        $queries = [
            'pageSize' => $this->pageSize,
            'currentItem' => $this->currentItem,
            'includeTotal' => true,
            'includeCustomerGroup' => true
        ];
        $kiotCustomers = $customerResource->list($queries)->getItems();
        foreach($kiotCustomers as $kiotCustomer) {
            $phone = $kiotCustomer->getContactNumber();
            $customer = Customer::wherePhone($phone)->first();
            $kiotService->saveKiotCustomerToLocal($customer, $kiotCustomer);
        }
    }
}
