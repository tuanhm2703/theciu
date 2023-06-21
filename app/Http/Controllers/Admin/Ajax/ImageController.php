<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Responses\Admin\BaseResponse;
use App\Services\StorageService;
use Illuminate\Http\Request;

class ImageController extends Controller {
    public function upload(Request $request) {
        $image = $request->file('image');
        $path = StorageService::put('/images', $image);
        resize_image($path, 1000);
        $path = "1000/$path";
        return BaseResponse::successWithRawData([
            'link' => StorageService::url($path)
        ]);
    }

    public function updateOrder(Request $request) {
        $paths = $request->paths;
        foreach ($paths as $index => $path) {
            $path = str_replace(StorageService::url(''), '', $path);
            Image::where('path', $path)->update(['order' => $index]);
        }
        return BaseResponse::success([
            'message' => 'Cập nhật vị trí ảnh thành công'
        ]);
    }
}
