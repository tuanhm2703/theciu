<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\DeleteCategoryRequest;
use App\Http\Requests\EditCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\ViewCategoryRequest;
use App\Models\Category;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index(ViewCategoryRequest $request) {
        return view('admin.pages.category.index');
    }

    public function productCategories(ViewCategoryRequest $request) {
        $categories = Category::whereType(CategoryType::PRODUCT)->with('categories.categories')->where('parent_id', null)->get();
        return view("admin.pages.product-category.product", compact('categories'));
    }

    public function store(StoreCategoryRequest $request) {
        $category = Category::create($request->all());
        if ($request->hasFile('image')) {
            $category->createImages([$request->file('image')]);
        }
        return BaseResponse::success([
            'message' => 'Tạo danh mục thành công'
        ]);
    }

    public function edit(EditCategoryRequest $request, Category $category) {
        $category->image;
        return view('admin.pages.category.form.edit', compact('category'));
    }

    public function update(Category $category, UpdateCategoryRequest $request) {
        $category->update($request->all());
        if ($request->hasFile('image')) {
            optional($category->image)->delete();
            $category->createImages([$request->file('image')]);
        }
        return BaseResponse::success([
            'message' => 'Cập nhật danh mục thành công'
        ]);
    }

    public function destroy(Category $category, DeleteCategoryRequest $request) {
        $category->delete();
        return BaseResponse::success([
            'message' => 'Xoá danh mục thành công'
        ]);
    }

    public function createProductCategory(CreateCategoryRequest $request) {
        return view('admin.pages.product-category.form.create');
    }

    public function editProductCategory(Category $category, EditCategoryRequest $request) {
        $category->image;
        return view('admin.pages.product-category.form.edit', compact('category'));
    }
}
