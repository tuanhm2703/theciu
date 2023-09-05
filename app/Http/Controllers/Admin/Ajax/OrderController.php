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
        if($request->from) {
            $from = carbon($request->from)->format('Y-m-d H:i:s');
            $orders->where('created_at', '>', $from);
        }
        if($request->to) {
            $to = carbon($request->to)->format('Y-m-d H:i:s');
            $orders->where('created_at', '<', $to);
        }
        if($order_status != OrderStatus::ALL) $orders->where('order_status', $order_status);
        if($request->has('order_sub_status')) $orders->where('sub_status', $request->order_sub_status);
        $order_counts = Order::selectRaw('count(id) as order_count, order_status')->groupBy('order_status')->get();
        $order_counts[] = [
            'order_status' => OrderStatus::ALL,
            'order_count' => $order_counts->sum('order_count')
        ];
        $result = DataTables::of($orders)
        ->filterColumn('phone', function($query, $keyword) {
            $query->whereHas('shipping_address', function($q) use ($keyword) {
                $q->where('addresses.phone', $keyword);
            });
        })
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
        ->addColumn('checkbox', function($order) {
            return view('admin.pages.order.components.checkbox', compact('order'));
        })
        ->make(true);
        $result->original['order_counts'] = $order_counts;
        $result->setData($result->original);
        return $result;
    }
}
