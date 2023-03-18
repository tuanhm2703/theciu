<?php

namespace App\Jobs;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\ProductResource;

class SyncKiotVietProductWarehouse implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $inventory;
    public function __construct(Inventory $inventory) {
        $this->inventory = $inventory;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        try {
            $this->inventory->syncKiotWarehouse();
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
