<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportOrder implements FromCollection {
    public $begin;
    public $end;
    public $order_status = 0;
    public function __construct($begin, $end, $order_status = 0) {
        $this->begin = $begin;
        $this->end = $end;
        $this->order_status = $order_status;
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection(){
        $orders = Order::leftJoin('order_items', function ($q) {
            $q->on('orders.id', 'order_items.order_id');
        })->leftJoin('inventories', function ($q) {
            $q->on('inventories.id', 'order_items.inventory_id');
        })->leftJoin('customers', function ($q) {
            $q->on('customers.id', 'orders.customer_id');
        })->whereBetween('orders.created_at', [$this->begin, $this->end]);
        if ($this->order_status != 0) {
            $orders->where('orders.order_status', $this->order_status);
        }
        $data = $orders->select(['orders.order_number as "mã đơn hàng"', 'inventories.sku as "Mã sản phẩm"', 'order_items.name as "Tên sản phẩm"', 'order_items.quantity as "Số lượng"', 'order_items.total as "Doanh thu"', 'orders.created_at as "Thời gian"', DB::raw('concat(customers.last_name," ", customers.first_name)')])->get();
        return $data;
    }
}
