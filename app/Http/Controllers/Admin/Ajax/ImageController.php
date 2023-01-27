<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Responses\Admin\BaseResponse;
use App\Services\StorageService;
use Illuminate\Http\Request;

class ImageController extends Controller {
    public function upload(Request $request) {
        $images = $request->file('images');
        $paths = [];
        foreach ($images as $image) {
            $path = StorageService::put('/images', $image);
            $paths[] = StorageService::url($path);
        }
        return BaseResponse::success([
            'paths' => $paths
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
