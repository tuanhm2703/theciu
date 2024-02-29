<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BannerResource;
use App\Models\Banner;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function getAll(Request $request) {
        $banners = Banner::active()->banner()->available()->with('desktopImage', 'phoneImage')->orderBy('order')->orderBy('updated_at', 'desc')->get();
        return BaseResponse::success(BannerResource::collection($banners));
    }

}
