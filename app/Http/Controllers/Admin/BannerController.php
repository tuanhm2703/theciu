<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index() {
        return view('admin.pages.appearance.banner.index');
    }

    public function create() {
        return view('admin.pages.appearance.banner.create');
    }

    public function store(Request $request) {
        $banner = Banner::create($request->all());
        if($request->hasFile('image')) {
            $banner->createImages([$request->file('image')]);
        }
        return BaseResponse::success([
            'message' => 'Tạo banner thành công'
        ]);
    }

    public function edit(Banner $banner) {
        return view('admin.pages.appearance.banner.edit', compact('banner'));
    }

    public function update(Banner $banner, Request $request) {
        $banner->update($request->all());
        if($request->hasFile('image')) {
            $banner->image()->delete();
            $banner->createImages([$request->file('image')]);
        }
        return BaseResponse::success([
            'message' => 'Cập nhật banner thành công'
        ]);
    }

    public function destroy(Banner $banner) {
        $banner->delete();
        return BaseResponse::success([
            'message'  => 'Xoá banner thành công'
        ]);
    }
}
