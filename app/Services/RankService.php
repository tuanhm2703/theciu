<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\CustomerRank;
use App\Models\Order;
use App\Models\Rank;
use Illuminate\Support\Facades\DB;

class RankService {
    public static function updateCustomerRank() {
        $ranks = Rank::orderBy('min_value')->get();
        foreach ($ranks as $rank) {
            $time = now()->subMonths($rank->cycle);
            CustomerRank::whereIn('rank_id', $rank->id)->where('created_at', '<=', $time)->delete();
            $customer_ids = Order::select(DB::raw('sum(orders.subtotal) as total_revenue', "customer_id"))
            ->where("order_status", OrderStatus::DELIVERED)
            ->where("updated_at", ">", $time)->groupBy("customer_id")->having("total_revenue", ">=", $rank->min_value)->pluck('customer_id')->toArray();
            CustomerRank::whereIn('customer_id', $customer_ids)->delete();
            $rank->customers()->attach($customer_ids);
        }
    }
}
