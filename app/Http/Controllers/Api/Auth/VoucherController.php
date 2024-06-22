<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CartVoucherResource;
use App\Http\Resources\Api\VoucherResource;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Voucher;
use App\Responses\Admin\BaseResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller {
    public function all(Request $request) {
        $user = requestUser();
        $vouchers = $user->saved_vouchers;
        return BaseResponse::success(VoucherResource::collection($vouchers));
    }

    public function saveVoucher(Voucher $voucher, Request $request) {
        $user = requestUser();
        if($voucher->quantity > 0) {
            $user->saved_vouchers()->sync([
                $voucher->id => [
                    'is_used' => false,
                    'type' => $voucher->voucher_type_id
                ]
            ], false);
            $voucher->update([
                'quantity' => DB::raw('quantity - 1')
            ]);
            return BaseResponse::success([
                'message' => 'Lưu voucher thành công'
            ]);
        } else {
            return BaseResponse::error([
                'message' => 'Số lượng voucher đã hết'
            ]);
        }
    }

    public function getCartVoucher(Request $request) {
        $user = requestUser();
        $vouchers = Voucher::voucherForCart($user)->get();
        app()->singleton('ValidateVoucherData', function () use ($vouchers) {
            return Voucher::whereIn('id', $vouchers->pluck('id')->toArray())->withCount(['orders' => function ($q) {
                $q->where('orders.order_status', '!=', OrderStatus::CANCELED);
            }])->get();
        });
        $total = $user->cart->getTotalWithSelectedItems($request->selected_items ?? []);
        CartVoucherResource::$selected_items = $request->selected_items ?? [];
        CartVoucherResource::$saved_voucher_ids = $user->saved_vouchers()->pluck('vouchers.id')->toArray();
        CartVoucherResource::$cart = $user->cart;
        CartVoucherResource::$total = $total;
        return BaseResponse::success(CartVoucherResource::collection($vouchers));
    }
}
