<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class OrderCreatedListener {
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreatedEvent $event) {
        $order = $event->order;
        $order->createOrderHistory();
        foreach($order->vouchers as $voucher) {
            $voucher->decreaseQuantity($order->customer);
        }
        Cache::forget("voucher_used_$order->customer_id");
        $order->removeStock();
    }
}
