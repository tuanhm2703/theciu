<?php

namespace App\Listeners\Kiot;

use App\Events\Kiot\OrderDeliveredEvent;
use App\Services\KiotService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\OrderResource;

class OrderDeliveredListener
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
    public function handle(OrderDeliveredEvent $event)
    {
        $order = $event->order;
        if($order->kiot_order) {
            $orderResource = new OrderResource(App::make(Client::class));
            try {
                $kiotOrder = $orderResource->getByCode($order->kiot_order->kiot_code);
                KiotService::createKiotInvoice($kiotOrder, $order);
            } catch (\Throwable $th) {
                Log::error($th);
            }
        }
    }
}
