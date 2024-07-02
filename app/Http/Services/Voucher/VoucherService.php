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

    public function verifyVoucher(Voucher|int $voucher, Customer $user, int $total) {
        if (is_int($voucher)) $voucher = Voucher::find($voucher);
        if (!$voucher) return false;
        $vouchers = Voucher::voucherForCart($user)->get();
        $validateVoucherData = Voucher::whereIn('id', $vouchers->pluck('id')->toArray())->withCount(['orders' => function ($q) {
            $q->where('orders.order_status', '!=', OrderStatus::CANCELED);
        }])->get();
        if ($voucher->total_can_use <= $validateVoucherData->where('id', $voucher->id)->first()->orders_count) return false;
        if (!$voucher->isValidTime()) return false;
        if ($total < $voucher->min_order_value) return false;
        if ($voucher->for_new_customer && !$user->orders()->whereIn('orders.order_status', OrderStatus::processingStatus())->exists()) return false;
        if (!$user->saved_vouchers()->active()->public()->notExpired()->haveNotUsed()->where('vouchers.id', $voucher->id)->exists()) {
            if (!$voucher->canApplyForCustomer($user->id)) {
                return false;
            }
        }
        return true;
    }
}
