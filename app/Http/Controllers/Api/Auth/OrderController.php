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
        $pageSize = $request->pageSize ?? 10;
        $orderStatus = $request->orderStatus;
        $orders = $user->orders()->orderBy('created_at', 'desc')->with('inventories.image', 'inventories.attributes');
        if($orderStatus) $orders->where('order_status', $orderStatus);
        $orders = $orders->paginate($pageSize);
        $paginateData = $orders->toArray();
        return BaseResponse::success([
            'items' => OrderListResource::collection($orders),
            'total' => $paginateData['total'],
            'next_page' => $paginateData['next_page_url'],
            'prev_page' => $paginateData['prev_page_url'],
        ]);
    }

    public function details(Order $order) {
    }
}
