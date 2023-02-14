<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ViewCategoryRequest;
use App\Models\Category;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index(ViewCategoryRequest $request) {
        return view('admin.pages.category.index');
    }

    public function productCategories() {
        $categories = Category::whereType(CategoryType::PRODUCT)->with('categories.categories')->where('parent_id', null)->get();
        return view("admin.pages.product-category.product", compact('categories'));
    }

    public function store(Request $request) {
        $category = Category::create($request->all());
        if ($request->hasFile('image')) {
            $category->createImages([$request->file('image')]);
        }
        return BaseResponse::success([
            'message' => 'Tạo danh mục thành công'
        ]);
    }

    public function edit(Category $category) {
        $category->image;
        return view('admin.pages.category.form.edit', compact('category'));
    }

    public function update(Category $category, Request $request) {
        $category->update($request->all());
        if ($request->hasFile('image')) {
            optional($category->image)->delete();
            $category->createImages([$request->file('image')]);
        }
        return BaseResponse::success([
            'message' => 'Cập nhật danh mục thành công'
        ]);
    }

    public function destroy(Category $category) {
        $category->delete();
        return BaseResponse::success([
            'message' => 'Xoá danh mục thành công'
        ]);
    }

    public function createProductCategory() {
        return view('admin.pages.product-category.form.create');
    }

    public function editProductCategory(Category $category) {
        $category->image;
        return view('admin.pages.product-category.form.edit', compact('category'));
    }
}
