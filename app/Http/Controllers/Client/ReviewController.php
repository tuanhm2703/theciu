<?php

namespace App\Http\Controllers\Client;

use App\Enums\MediaType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateReviewRequest;
use App\Models\Review;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(CreateReviewRequest $request) {
        $voucher = customer()->gainReviewVoucher();
        $review = customer()->reviews()->create($request->all());
        if($request->hasFile('video')) {
            $review->createImages([$request->file('video')], MediaType::VIDEO, 'videos');
        }
        if($request->hasFile('images')) {
            $review->createImages($request->file('images'), MediaType::IMAGE, 'images');
        }
        return BaseResponse::success([
            'message' => 'Tạo review thành công',
            'voucher_view' => $voucher ? view('components.client.review-voucher-gift-component', compact('voucher'))->render() : null
        ]);
    }
}
