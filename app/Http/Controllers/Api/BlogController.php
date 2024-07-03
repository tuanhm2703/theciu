<?php

namespace App\Http\Controllers\Api;

use App\Enums\BlogType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BlogListResource;
use App\Http\Resources\Api\BlogResource;
use App\Http\Resources\Api\WebBlogResource;
use App\Models\Blog;
use App\Models\TheciuBlog;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class BlogController extends Controller {
    public function index(Request $request) {
        $type = $request->type ?? BlogType::WEB;
        $pageSize = $request->pageSize ?? 9;
        $blogs = Blog::with('image')->select('id', 'title', 'description', 'publish_date', 'slug', 'type', 'author_name', 'thumbnail')->with('categories:name,id,slug')->whereType($type)->paginate($pageSize);
        $paginateData = $blogs->toArray();
        return BaseResponse::success([
            'items' => BlogListResource::collection($blogs),
            'total' => $paginateData['total'],
            'next_page' => $paginateData['next_page_url'],
            'prev_page' => $paginateData['prev_page_url'],
        ]);
    }

    public function detail($slug) {
        $blog = Blog::whereSlug($slug)->with('image')->firstOrFail();
        return BaseResponse::success(new BlogResource($blog));
    }
    public function relatedBlog($slug, Request $request) {
        $limit = $request->limit ?? 3;
        $blog = Blog::whereSlug($slug)->firstOrFail();
        $type = $blog->type;
        $blogs = Blog::active()->where('id', '!=', $blog->id)->whereType($type)->whereHas('categories', function ($q) use ($blog) {
            $q->whereIn('categories.id', $blog->categories()->pluck('categories.id')->toArray());
        })->with('image')->select('id', 'title', 'description', 'publish_date', 'slug', 'type')->limit($limit)->get();
        return BaseResponse::success($blogs);
    }
}
