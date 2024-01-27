<?php

namespace App\Listeners\Kiot;

use App\Events\Kiot\OrderCreatedEvent;
use App\Services\KiotService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Throwable;
use VienThuong\KiotVietClient\Exception\KiotVietException;

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
        try {
            $result = KiotService::createKiotOrder($order);
        } catch (KiotVietException $th) {
            throw new Exception($th->getMessage(), 409);
        } catch (Throwable $th) {
            throw new Exception('Đã có lỗi xảy ra, vui lòng liên hệ bộ phận chăm sóc khách hàng để nhận hỗ trợ.', 422);
        }
    }
}
