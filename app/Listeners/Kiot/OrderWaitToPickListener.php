<?php

namespace App\Listeners\Kiot;

use App\Services\KiotService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\OrderResource;

class OrderWaitToPickListener
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
    public function handle($event)
    {
        $order = $event->order;
        try {
            KiotService::createKiotInvoice($order);
        } catch (\Throwable $th) {
            \Log::error($th);
        }
    }
}
