<?php

namespace App\Listeners\Kiot;

use App\Events\Kiot\OrderCanceledEvent;
use App\Services\KiotService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCanceledListener
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
    public function handle(OrderCanceledEvent $event)
    {
        $order = $event->order;
        try {
            KiotService::cancelKiotInvoice($order);
            KiotService::cancelKiotOrder($order);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
