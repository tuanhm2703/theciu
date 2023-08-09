<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BannerController extends Controller
{
    public function paginate() {
        $banners = Banner::query()->with('image', 'phoneImage', 'desktopImage');
        return DataTables::of($banners)
        ->editColumn('image', function($banner) {
            return view('admin.pages.appearance.banner.components.image', compact('banner'));
        })
        ->editColumn('status', function($banner) {
            return view('admin.pages.appearance.banner.components.status', compact('banner'));
        })
        ->editColumn('url', function($banner) {
            return view('admin.pages.appearance.banner.components.url', compact('banner'));
        })
        ->editColumn('title', function($banner) {
            return view('admin.pages.appearance.banner.components.title', compact('banner'));
        })
        ->addColumn('action', function($banner) {
            return view('admin.pages.appearance.banner.components.action', compact('banner'));
        })
        ->make(true);
    }

}
