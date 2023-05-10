<?php

namespace App\Listeners;

use App\Events\OrderCanceled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

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
    public function handle(OrderCanceled $event)
    {
        $order = $event->order;
        $order->refund();
        foreach($order->vouchers as $voucher) {
            $voucher->increaseQuantity($order->customer);
        }
        Cache::forget("voucher_used_$order->customer_id");
        $order->restock();
        $order->cancelShippingOrder();
    }
}
