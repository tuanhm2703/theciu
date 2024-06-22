<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrderListResource;
use App\Models\Order;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request) {
        $user = requestUser();
        $from = $request->from ? carbon($request->from)->startOfDay() : Order::min('created_at');
        $to = $request->to ? carbon($request->to)->endOfDay() : Order::max('created_at');
        $pageSize = $request->pageSize ?? 10;
        $orderStatus = $request->orderStatus;
        $orders = $user->orders()->whereBetween('orders.created_at', [$from, $to])
        ->orderBy('created_at', 'desc')
        ->with('inventories.image', 'inventories.attributes', 'payment_method', 'vouchers', 'order_histories');
        if($orderStatus) $orders->where('order_status', $orderStatus);
        $orders = $orders->paginate($pageSize);
        $paginateData = $orders->toArray();
        $order_counts = Order::selectRaw('count(id) as order_count, order_status')->groupBy('order_status')->get();
        return BaseResponse::success([
            'items' => OrderListResource::collection($orders),
            'total' => $paginateData['total'],
            'next_page' => $paginateData['next_page_url'],
            'prev_page' => $paginateData['prev_page_url'],
            'order_counts' => $order_counts
        ]);
    }

    public function details(Order $order) {
    }
}
