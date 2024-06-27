<?php

namespace App\Http\Services\Voucher;

use App\Enums\OrderStatus;
use App\Http\Resources\Api\CartVoucherResource;
use App\Models\Customer;
use App\Models\Voucher;

class VoucherService {
    public function getUserCartVoucher(Customer $user) {
        $vouchers = Voucher::getCartVoucher($user)->get();
    }

    public function getUserCartVoucherResource(Customer $user, array $selected_items = []) {
        $vouchers = Voucher::voucherForCart($user)->get();
        app()->singleton('ValidateVoucherData', function () use ($vouchers) {
            return Voucher::whereIn('id', $vouchers->pluck('id')->toArray())->withCount(['orders' => function ($q) {
                $q->where('orders.order_status', '!=', OrderStatus::CANCELED);
            }])->get();
        });
        $total = $user->cart->getTotalWithSelectedItems($selected_items ?? []);
        CartVoucherResource::$selected_items = $selected_items ?? [];
        CartVoucherResource::$saved_voucher_ids = $user->saved_vouchers()->pluck('vouchers.id')->toArray();
        CartVoucherResource::$cart = $user->cart;
        CartVoucherResource::$total = $total;
        return CartVoucherResource::collection($vouchers);
    }
}
