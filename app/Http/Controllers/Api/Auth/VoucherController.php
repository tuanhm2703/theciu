<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\VoucherResource;
use App\Models\Voucher;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function all(Request $request) {
        $user = $request->user();
        $vouchers = $user->saved_vouchers;
        return BaseResponse::success(VoucherResource::collection($vouchers));
    }

    public function saveVoucher(Voucher $voucher, Request $request) {
        $user = $request->user();
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
}
