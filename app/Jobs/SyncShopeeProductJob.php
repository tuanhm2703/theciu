<?php

namespace App\Jobs;

use App\Http\Services\ShopeeService\ShopeeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncShopeeProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private ShopeeService $shopeeService;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private $offset, private $pageSize, private $status = 'NORMAL')
    {
        $this->shopeeService = new ShopeeService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $productList = $this->shopeeService->getItemList($this->offset, $this->pageSize, $this->status);
        $ids = collect($productList->response->item)->pluck('item_id')->toArray();
        $this->shopeeService->syncShopeeProductByIds($ids);
        if($productList->response->has_next_page) {
            $this->offset += $this->pageSize;
            dispatch(new SyncShopeeProductJob($this->offset, $this->pageSize, $this->status));
        }
    }
}
