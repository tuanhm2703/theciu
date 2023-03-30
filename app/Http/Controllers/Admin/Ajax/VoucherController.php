<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VoucherController extends Controller {
    public function paginate() {
        $vouchers = Voucher::query();
        return DataTables::of($vouchers)
        ->editColumn('name', function($voucher) {
            return view('admin.pages.promotion.voucher.components.name', compact('voucher'));
        })
        ->editColumn('status', function($voucher) {
            return view('admin.pages.promotion.voucher.components.status', compact('voucher'));
        })
        ->editColumn('action', function($voucher) {
            return view('admin.pages.promotion.voucher.components.action', compact('voucher'));
        })
        ->editColumn('begin', function($voucher) {
            return $voucher->begin->format('d-m-Y H:i');
        })
        ->editColumn('end', function($voucher) {
            return $voucher->end->format('d-m-Y H:i');
        })
        ->make(true);
    }
}
