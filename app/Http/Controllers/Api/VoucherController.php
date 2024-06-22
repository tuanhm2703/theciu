<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\VoucherResource;
use App\Models\Voucher;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function getAll(Request $request) {
        if(requestUser()) {
            $vouchers = Voucher::public()->active()->saveable()->with('voucher_type')->available()->get();
            $saved_vouchers = requestUser()->saved_vouchers()->available()->public()->get();
            $vouchers->each(function($voucher) use ($saved_vouchers) {
                $voucher->saved = in_array($voucher->id, $saved_vouchers->pluck('id')->toArray());
                $voucher->used = $saved_vouchers->where('id', $voucher->id)->where('pivot.is_used', 1)->first() ? true : false;
            });
            $vouchers = $vouchers->filter(function($value, $key) {
                return $value->used == false;
            });
        } else {
            $vouchers = Voucher::public()->active()->available()->with('voucher_type')->saveable()->get();
        }
        // return $vouchers;
        return BaseResponse::success(VoucherResource::collection($vouchers));
    }
}
