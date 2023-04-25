<?php

namespace App\Listeners\Kiot;

use App\Events\Kiot\OrderCreatedEvent;
use App\Services\KiotService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreatedListener
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
    public function handle(OrderCreatedEvent $event)
    {
        $order = $event->order;
        $result = KiotService::createKiotOrder($order);
        if($result == false) {
            throw new Exception('Đã có lỗi xảy ra, vui lòng liên hệ bộ phận chăm sóc khách hàng để nhận hỗ trợ.', 422);
        }
    }
}
