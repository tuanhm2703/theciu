<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller {
    public function paginate(Request $request) {
        $order_status = $request->order_status ?? OrderStatus::ALL;
        $orders = Order::query()->with(['inventories' => function($q) {
            $q->withTrashed();
        }]);
        if($order_status != OrderStatus::ALL) $orders->where('order_status', $order_status);
        return DataTables::of($orders)
        ->addColumn('header', function($order) {
            return view('admin.pages.order.components.order_header', compact('order'));
        })
        ->editColumn('created_at', function($order) {
            return view('admin.pages.order.components.created-date', compact('order'));
        })
        ->addColumn('shipping_service', function($order) {
            return view('admin.pages.order.components.shipping-service', compact('order'));
        })
        ->addColumn('status', function($order) {
            return view('admin.pages.order.components.status', compact('order'));
        })
        ->addColumn('items', function($order) {
            return view('admin.pages.order.components.items', compact('order'));
        })
        ->editColumn('subtotal', function($order) {
            return view('admin.pages.order.components.turnover', compact('order'));
        })
        ->addColumn('delivery_date', function($order) {
            return view('admin.pages.order.components.delivery-date', compact('order'));
        })
        ->addColumn('action', function($order) {
            return view('admin.pages.order.components.action', compact('order'));
        })
        ->make(true);
    }
}
