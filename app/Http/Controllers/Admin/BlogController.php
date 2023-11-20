<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateBlogRequest;
use App\Http\Requests\Admin\EditBlogRequest;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Http\Requests\Admin\ViewBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(ViewBlogRequest $request) {
        return view('admin.pages.appearance.blog.index');
    }

    public function create(CreateBlogRequest $request) {
        return view('admin.pages.appearance.blog.create');
    }

    public function store(StoreBlogRequest $request) {
        $blog = Blog::create($request->all());
        if($request->hasFile('image')) {
            $blog->createImages([$request->file('image')]);
        }
        return BaseResponse::success([
            'message' => 'Thêm bài viết thành công!'
        ]);
    }

    public function edit(EditBlogRequest $request, Blog $blog) {
        $blog->category_ids = $blog->categories()->pluck('categories.id')->toArray();
        $selected = $blog->categories()->select('categories.id as id', 'categories.name as text')->pluck('text', 'id');
        return view('admin.pages.appearance.blog.edit', compact('blog', 'selected'));
    }

    public function update(Blog $blog, UpdateBlogRequest $request) {
        $request->merge([
            'status' => $request->status == 'on' ? 1 : 0
        ]);
        $blog->update($request->all());
        if($request->hasFile('image')) {
            optional($blog->image)->delete();
            $blog->createImages([$request->file('image')]);
        }
        $category_ids = [];
        foreach($request->category_ids as $id) {
            $category = Category::firstOrCreate([
                'id' => $id,
                'type' => CategoryType::BLOG
            ], [
                'name' => $id,
                'type' => CategoryType::BLOG
            ]);
            $category_ids[] = $category->id;
        }
        $blog->categories()->sync($category_ids);
        return BaseResponse::success([
            'message' => 'Cập nhật bài viết thành công'
        ]);
    }

    public function recruitmentBlog() {
        return view('admin.pages.recruitment.blog.index');
    }
}
