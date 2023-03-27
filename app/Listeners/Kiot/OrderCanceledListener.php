<?php

namespace App\Listeners\Kiot;

use App\Events\Kiot\OrderCanceledEvent;
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
        $order->cancelKiotInvoice();
    }
}
