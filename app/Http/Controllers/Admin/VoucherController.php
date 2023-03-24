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
        $voucher_types = VoucherType::active()->get();
        return view('admin.pages.promotion.voucher.edit', compact('voucher', 'voucher_types'));
    }

    public function quickView(Voucher $voucher) {
        $voucher_types = VoucherType::active()->get();
        return view('admin.pages.promotion.voucher.quickView', compact('voucher', 'voucher_types'));
    }

    public function create() {
        $voucher_types = VoucherType::active()->get();
        return view('admin.pages.promotion.voucher.create', compact('voucher_types'));
    }

    public function store(CreateVoucherRequest $request) {
        Voucher::create($request->all());
        return BaseResponse::success([
            'message' => 'Tạo mã khuyến mãi thành công'
        ]);
    }

    public function update(Voucher $voucher, Request $request) {
        $voucher->update($request->all());
        return BaseResponse::success([
            'message' => 'Cập nhật voucher thành công'
        ]);
    }
}
