<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreatePageRequest;
use App\Http\Requests\Admin\DeletePageRequest;
use App\Http\Requests\Admin\EditPageRequest;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Http\Requests\Admin\ViewPageRequest;
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
    public function index(ViewPageRequest $request) {
        return view('admin.pages.page.index');
    }

    public function create(CreatePageRequest $request) {
        return view('admin.pages.page.create');
    }

    public function store(StorePageRequest $request) {
        $page = Page::create($request->all());
        if($request->has('meta')) {
            $page->syncMetaTag($request->meta);
        }
        session()->flash('success', 'Tạo trang thành công');
        return redirect()->route('admin.page.index');
    }

    public function edit(EditPageRequest $request, Page $page) {
        $meta_tag = $page->metaTag;
        if($meta_tag) {
            $page->meta = $meta_tag->payload;
        }
        return view('admin.pages.page.edit', compact('page'));
    }

    public function update(Page $page, UpdatePageRequest $request) {
        $page->update($request->all());
        if($request->has('meta')) {
            $page->syncMetaTag($request->meta);
        }
        session()->flash('success', 'Cập nhật trang thành công');
        return back();
    }

    public function destroy(Page $page, DeletePageRequest $request) {
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
        return view("admin.pages.profile-static");
    }

    public function signin() {
        return view("pages.sign-in-static");
    }

    public function signup() {
        return view("pages.sign-up-static");
    }
}
