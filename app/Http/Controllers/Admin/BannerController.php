<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MediaType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateBannerRequest;
use App\Http\Requests\Admin\DeleteBannerRequest;
use App\Http\Requests\Admin\EditBannerRequest;
use App\Http\Requests\Admin\StoreBannerRequest;
use App\Http\Requests\Admin\UpdateBannerRequest;
use App\Http\Requests\Admin\ViewBannerRequest;
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
        if ($request->hasFile('phoneImage')) {
            $banner->createImages([$request->file('phoneImage')], MediaType::PHONE);
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
        if ($request->hasFile('phoneImage')) {
            $banner->phoneImage()->delete();
            $banner->createImages([$request->file('phoneImage')], MediaType::PHONE);
        }
        return BaseResponse::success([
            'message' => 'Cập nhật banner thành công'
        ]);
    }
    public function destroy(DeleteBannerRequest $request, Banner $banner) {
        $banner->delete();
        return BaseResponse::success([
            'message'  => 'Xoá banner thành công'
        ]);
    }
}
