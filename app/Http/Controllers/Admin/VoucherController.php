<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateVoucherRequest;
use App\Models\Voucher;
use App\Models\VoucherType;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class VoucherController extends Controller {
    public function edit(Voucher $voucher) {
        return view('admin.pages.promotion.voucher.edit', compact('voucher'));
    }

    public function quickView(Voucher $voucher) {
        $voucher_types = VoucherType::active()->get();
        return view('admin.pages.promotion.voucher.quickview', compact('voucher', 'voucher_types'));
    }

    public function create() {
        return view('admin.pages.promotion.voucher.create');
    }

    public function store(CreateVoucherRequest $request) {
        $input = $request->all();
        if(!isset($input['max_discount_amount'])) {
            $input['max_discount_amount'] = null;
        }
        Voucher::create($input);
        return BaseResponse::success([
            'message' => 'Tạo mã khuyến mãi thành công'
        ]);
    }

    public function update(Voucher $voucher, Request $request) {
        $input = $request->all();
        $input['saveable'] = $input['saveable'] == 'on';
        if(!isset($input['max_discount_amount'])) {
            $input['max_discount_amount'] = null;
        }
        $voucher->update($input);
        return BaseResponse::success([
            'message' => 'Cập nhật voucher thành công'
        ]);
    }
}
