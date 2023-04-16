<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ajax\ViewCategoryRequest;
use App\Models\Category;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function getAllCategories(ViewCategoryRequest $request)
    {
        $type = $request->type;
        $categories = Category::where('parent_id', null)->with(['categories.categories' => function ($q) use ($type) {
            if ($type) {
                $q->where('type', $type);
            }
        }]);
        if ($type) {
            $categories = $categories->where('type', $type);
        }
        $categories = $categories->get();
        return BaseResponse::success([
            'message' => 'Thao tác thành công',
            'data' => $categories
        ]);
    }

    public function ajaxSearch(Request $request)
    {
        $q = $request->q;
        $categories = Category::query();
        $type = $request->type;
        if ($q) {
            $categories->search('name', $q);
        }
        if ($type) {
            $categories = $categories->where('type', $type);
        }
        $categories = $categories->select('name as text', 'id')->distinct()->paginate(8);
        return BaseResponse::success($categories->toArray()['data']);
    }

    public function paginate(ViewCategoryRequest $request)
    {
        $type = $request->type;
        $parentId = $request->parentId;
        $categories = Category::where('parent_id', $parentId)->with('categories.categories', 'image')->withCount('products');
        if ($type) {
            $categories = $categories->where('type', $type);
        } else {
            $categories->whereNotIn('type', [CategoryType::PRODUCT, CategoryType::BLOG]);
        }
        return DataTables::of($categories)
            ->editColumn('name', function ($category) {
                return view('admin.pages.category.components.name', compact('category'));
            })
            ->editColumn('status', function ($category) {
                return view('admin.pages.category.components.status', compact('category'));
            })
            ->editColumn('type', function ($category) {
                return view('admin.pages.category.components.type', compact('category'));
            })
            ->addColumn('action', function ($category) {
                return view('admin.pages.category.components.action', compact('category'));
            })
            ->make(true);
    }

    public function paginateProductCategory(Request $request)
    {
        $type = $request->type;
        $parentId = $request->parentId;
        $categories = Category::where('parent_id', $parentId)->with('categories.categories', 'image')->withCount('products');
        if ($type) {
            $categories = $categories->where('type', $type);
        } else {
            $categories->whereNotIn('type', [CategoryType::PRODUCT, CategoryType::BLOG]);
        }
        $result = DataTables::of($categories)
            ->editColumn('name', function ($category) {
                return view('admin.pages.product-category.components.name', compact('category'));
            })
            ->editColumn('status', function ($category) {
                return view('admin.pages.product-category.components.status', compact('category'));
            })
            ->editColumn('type', function ($category) {
                return view('admin.pages.product-category.components.type', compact('category'));
            })
            ->addColumn('action', function ($category) {
                return view('admin.pages.product-category.components.action', compact('category'));
            })
            ->make(true);
        if ($parentId) {
            $category = Category::find($parentId);
            $category->edit_url = route('admin.category.product.edit', $category->id);
            $result->original['category'] = $category;
        }
        $result->setData($result->original);
        return $result;
    }

    public function viewCreate(Request $request)
    {
        return view('admin.pages.category.form.create');
    }

    public function update(Category $category, Request $request)
    {
        $category->update($request->all());
        return BaseResponse::success([
            'message' => 'Cập nhật danh mục thành công'
        ]);
    }

    public function viewAddProduct(Category $category, Request $request)
    {
        $productIds = $category->products()->pluck('products.id')->toArray();
        return view('admin.pages.category.modal.product', compact('category', 'productIds'));
    }

    public function addProduct(Category $category, Request $request)
    {
        $category->products()->sync($request->productIds);
        return BaseResponse::success([
            'message' => 'Thêm sản phẩm vào danh mục thành công'
        ]);
    }
}
