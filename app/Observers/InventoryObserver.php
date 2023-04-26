<?php

namespace App\Observers;

use App\Jobs\SyncKiotVietProductWarehouse;
use App\Models\Inventory;

class InventoryObserver
{
    public function created(Inventory $inventory)
    {
        dispatch(new SyncKiotVietProductWarehouse($inventory));
    }

    public function updated(Inventory $inventory)
    {
        if ($inventory->isDirty('sku')) {
            dispatch(new SyncKiotVietProductWarehouse($inventory))->onQueue('syncKiotStock');
        }
    }
}
