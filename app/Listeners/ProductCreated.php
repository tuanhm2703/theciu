<?php

namespace App\Listeners;

use App\Events\ProductCreated as EventsProductCreated;
use App\Jobs\SyncKiotVietProductWarehouse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EventsProductCreated $productCreatedEvent)
    {
        foreach ($productCreatedEvent->product->inventories as $inventory) {
            dispatch(new SyncKiotVietProductWarehouse($inventory));
        }
    }
}
