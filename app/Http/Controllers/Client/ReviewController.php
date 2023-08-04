<?php

namespace App\Http\Controllers\Client;

use App\Enums\MediaType;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateReviewRequest;
use App\Models\Order;
use App\Models\Review;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller {
    public function store(CreateReviewRequest $request) {
        DB::beginTransaction();
        try {
            $order = Order::find($request->order_id);
            $voucher = customer()->gainReviewVoucher();
            if ($order->order_status !== OrderStatus::DELIVERED) {
                DB::rollBack();
                return BaseResponse::error([
                    'message' => 'Yêu cầu không hợp lệ'
                ], 400);
            }
            if ($order->updated_at < $voucher?->begin) {
                DB::rollback();
                $voucher = null;
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error($th);
            return BaseResponse::error([
                'message' => 'Đã có lỗi xảy ra'
            ], 400);
        }
        $review = customer()->reviews()->create($request->all());
        if ($request->hasFile('video')) {
            $review->createImages([$request->file('video')], MediaType::VIDEO, 'videos');
        }
        if ($request->hasFile('images')) {
            $review->createImages($request->file('images'), MediaType::IMAGE, 'images');
        }
        return BaseResponse::success([
            'message' => 'Tạo review thành công',
            'voucher_view' => $voucher ? view('components.client.review-voucher-gift-component', compact('voucher'))->render() : null
        ]);
    }

    public function like(Review $review) {
        if (!$review->customer_liked || !in_array(customer()->id, $review->customer_liked)) {
            $arr = $review->customer_liked ?? [];
            array_push($arr, customer()->id);
            $review->likes = count(array_unique($arr));
            $review->customer_liked = $arr;
            $review->save();
        }
        return BaseResponse::success([
            'likes' => count($review->customer_liked)
        ]);
    }
}
