<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Responses\Admin\BaseResponse;
use App\Services\StorageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
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
}
