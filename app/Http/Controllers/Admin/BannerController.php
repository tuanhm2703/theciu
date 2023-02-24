<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBannerRequest;
use App\Http\Requests\DeleteBannerRequest;
use App\Http\Requests\EditBannerRequest;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Requests\ViewBannerRequest;
use App\Models\Banner;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class BannerController extends Controller {
    public function index(ViewBannerRequest $request) {
        return view('admin.pages.appearance.banner.index');
    }

    public function create(CreateBannerRequest $request) {
        return view('admin.pages.appearance.banner.create');
    }

    public function store(StoreBannerRequest $request) {
        $banner = Banner::create($request->all());
        if ($request->hasFile('image')) {
            $banner->createImages([$request->file('image')]);
        }
        return BaseResponse::success([
            'message' => 'Tạo banner thành công'
        ]);
    }

    public function edit(EditBannerRequest $request, Banner $banner) {
        return view('admin.pages.appearance.banner.edit', compact('banner'));
    }

    public function update(Banner $banner, UpdateBannerRequest $request) {
        $banner->update($request->all());
        if ($request->hasFile('image')) {
            $banner->image()->delete();
            $banner->createImages([$request->file('image')]);
        }
        return BaseResponse::success([
            'message' => 'Cập nhật banner thành công'
        ]);
    }

    public function destroy(DeleteBannerRequest $banner) {
        $banner->delete();
        return BaseResponse::success([
            'message'  => 'Xoá banner thành công'
        ]);
    }
}
