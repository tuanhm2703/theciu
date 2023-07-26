<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Voucher;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReviewController extends Controller
{
    public function index() {
        return view('admin.pages.review.index');
    }

    public function paginate() {
        $reviews = Review::query()->with('customer', 'order.products');
        return DataTables::of($reviews)
        ->editColumn('status', function($review) {
            return view('admin.pages.review.components.status', compact('review'));
        })
        ->editColumn('reply', function($review) {
            return view('admin.pages.review.components.reply', compact('review'));
        })
        ->addColumn('action', function($review) {
            return view('admin.pages.review.components.action', compact('review'));
        })
        ->editColumn('details', function($review) {
            return view('admin.pages.review.components.details', compact('review'));
        })
        ->make(true);
    }

    public function settingVoucher() {
        return view('admin.pages.review.components.voucher');
    }

    public function vouchers() {
        $vouchers = Voucher::with('voucher_type')->canApplyForReview();
        $review_voucher = app()->get('ReviewVoucher');
        return DataTables::of($vouchers)
        ->editColumn('name', function($voucher) {
            return view('admin.pages.promotion.voucher.components.name', compact('voucher'));
        })
        ->editColumn('status', function($voucher) {
            return view('admin.pages.promotion.voucher.components.status', compact('voucher'));
        })
        ->editColumn('display', function($voucher) {
            return view('admin.pages.promotion.voucher.components.display', compact('voucher'));
        })
        ->editColumn('action', function($voucher) use ($review_voucher) {
            return view('admin.pages.review.components.voucher_action', compact('voucher', 'review_voucher'));
        })
        ->editColumn('begin', function($voucher) {
            return $voucher->begin->format('d-m-Y H:i');
        })
        ->editColumn('end', function($voucher) {
            return $voucher->end->format('d-m-Y H:i');
        })
        ->make(true);
    }

    public function replyForm(Review $review) {
        return view('admin.pages.review.components.reply_form', compact('review'));
    }

    public function replyReview(Review $review, Request $request) {
        $input = $request->all();
        if($request->reply && !empty($request->review)) {
            $input['reply_by'] = user()->id;
        }
        $review->update($input);
        return BaseResponse::success([
            'message' => "Đã trả lời review #$review->id"
        ]);
    }

    public function chooseVoucherforReview(Request $request) {
        $id = $request->voucher_id;
        $setting = Setting::firstOrCreate([
            'name' => 'review_voucher'
        ], [
            'data' => ""
        ]);
        $setting->data = "$id";
        $setting->save();
        session()->flash('success', 'Cập nhật voucher cho danh mục review thành công');
        return back();
    }

    public function deleteVoucherForReview() {
        $setting = Setting::firstOrCreate([
            'name' => 'review_voucher'
        ], [
            'data' => ""
        ]);
        $setting->data = null;
        $setting->save();
        session()->flash('success', 'Cập nhật voucher cho danh mục review thành công');
        return back();
    }

    public function active(Review $review) {
        $review->status = StatusType::ACTIVE;
        $review->save();
        return BaseResponse::success([
            'message' => 'Review đã được kiểm duyệt'
        ]);
    }
    public function deactive(Review $review) {
        $review->status = StatusType::INACTIVE;
        $review->save();
        return BaseResponse::success([
            'message' => 'Review đã được ẩn'
        ]);
    }
}
