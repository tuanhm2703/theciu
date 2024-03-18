<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DisplayType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateVoucherRequest;
use App\Http\Requests\Admin\UpdateVoucherRequest;
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
        $input['saveable'] = $request->saveable ? $request->saveable == 'on' : false;
        $input['featured'] = $request->featured ? $request->featured == 'on' : false;
        $input['status'] = $request->status ? $request->status == 'on' : false;
        $input['for_new_customer'] = $request->for_new_customer ? $request->for_new_customer == 'on' : false;
        if ($request->has('batch-create') && $input['batch-create'] === 'on' && $request->display === DisplayType::PRIVATE) {
            $input['total_quantity'] = 1;
            $input['total_can_use'] = 1;
            $input['customer_limit'] = 1;
            $input['saveable'] = false;
            $input['featured'] = false;
            foreach ($request->codes as $code) {
                $input['code'] = $code;
                Voucher::create($input);
            }
        } else {
            if (!isset($input['max_discount_amount'])) {
                $input['max_discount_amount'] = null;
            }
            Voucher::create($input);
        }
        return BaseResponse::success([
            'message' => 'Tạo mã khuyến mãi thành công'
        ]);
    }

    public function update(Voucher $voucher, UpdateVoucherRequest $request) {
        $input = $request->all();
        $input['saveable'] = $request->saveable ? $request->saveable == 'on' : false;
        $input['featured'] = $request->featured ? $request->featured == 'on' : false;
        $input['status'] = $request->status ? $request->status == 'on' : false;
        $input['for_new_customer'] = $request->for_new_customer ? $request->for_new_customer == 'on' : false;
        $input['quantity'] = $voucher->total_quantity < $request->total_quantity ? $voucher->quantity + ($request->total_quantity - $voucher->total_quantity) : $voucher->quantity - ($voucher->total_quantity - $request->total_quantity);
        $input['quantity'] = $input['quantity'] > 0 ? $input['quantity'] : 0;
        if (!isset($input['max_discount_amount'])) {
            $input['max_discount_amount'] = null;
        }
        $voucher->update($input);
        return BaseResponse::success([
            'message' => 'Cập nhật voucher thành công'
        ]);
    }

    public function destroy(Voucher $voucher) {
        $voucher->delete();
        return BaseResponse::success([
            'message' => 'Xoá voucher thành công'
        ]);
    }
}
