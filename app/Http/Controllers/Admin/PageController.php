<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class PageController extends Controller {
    /**
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('admin.pages.page.index');
    }

    public function create() {
        return view('admin.pages.page.components.create');
    }

    public function store(Request $request) {
        Page::create($request->all());
        return BaseResponse::success([
            'message' => 'Tạo trang thành công'
        ]);
    }

    public function edit(Page $page) {
        return view('admin.pages.page.components.edit', compact('page'));
    }

    public function update(Page $page, Request $request) {
        $page->update($request->all());
        return BaseResponse::success([
            'message' => 'Cập nhật trang thành công'
        ]);
    }

    public function destroy(Page $page) {
        $page->delete();
        return BaseResponse::success([
            'message' => 'Xoá trang thành công'
        ]);
    }

    public function vr() {
        return view("pages.virtual-reality");
    }

    public function rtl() {
        return view("pages.rtl");
    }

    public function profile() {
        return view("pages.profile-static");
    }

    public function signin() {
        return view("pages.sign-in-static");
    }

    public function signup() {
        return view("pages.sign-up-static");
    }
}
