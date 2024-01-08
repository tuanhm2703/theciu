<?php

namespace App\Http\Controllers\Api;

use App\Enums\BlogType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BlogResource;
use App\Models\Blog;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request) {
        $type = $request->type ?? BlogType::WEB;
        $pageSize = $request->pageSize ?? 9;
        $blogs = Blog::with('image')->select('id', 'title', 'description', 'publish_date', 'slug', 'type')->whereType($type)->paginate($pageSize);
        return BaseResponse::success($blogs);
    }

    public function detail($slug) {
        $blog = Blog::whereSlug($slug)->with('image')->firstOrFail();
        return BaseResponse::success(new BlogResource($blog));
    }
    public function relatedBlog($slug, Request $request) {
        $limit = $request->limit ?? 3;
        $blog = Blog::whereSlug($slug)->firstOrFail();
        $type = $blog->type;
        $blogs = Blog::active()->where('id', '!=', $blog->id)->whereType($type)->whereHas('categories', function($q) use ($blog) {
            $q->whereIn('categories.id', $blog->categories()->pluck('categories.id')->toArray());
        })->with('image')->select('id', 'title', 'description', 'publish_date', 'slug', 'type')->limit($limit)->get();
        return BaseResponse::success($blogs);
    }
}
