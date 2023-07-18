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

    public function like(Review $review) {
        if(!$review->customer_liked || !in_array(customer()->id, $review->customer_liked)) {
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
