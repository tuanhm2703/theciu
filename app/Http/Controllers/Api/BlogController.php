<?php

namespace App\Http\Controllers\Api;

use App\Enums\BlogType;
use App\Http\Controllers\Controller;
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
        if ($type === BlogType::WEB) {
            $blogs = TheciuBlog::where('post_type', 'post')->where('ping_status', 'open')
                ->whereHas('meta_attachment')
                ->with('meta_attachment', function ($q) {
                    return $q->with('meta_attachment');
                })
                ->where('post_status', 'publish')
                ->orderBy('post_date', 'desc')
                ->select('post_title', 'post_excerpt', 'post_status', 'ID', 'post_date', 'post_type')
                ->paginate($pageSize);
            $paginateData = $blogs->toArray();
            return BaseResponse::success([
                'items' => WebBlogResource::collection($blogs),
                'total' => $paginateData['total'],
                'next_page' => $paginateData['next_page_url'],
                'prev_page' => $paginateData['prev_page_url']
            ]);
        }
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
        $blogs = Blog::active()->where('id', '!=', $blog->id)->whereType($type)->whereHas('categories', function ($q) use ($blog) {
            $q->whereIn('categories.id', $blog->categories()->pluck('categories.id')->toArray());
        })->with('image')->select('id', 'title', 'description', 'publish_date', 'slug', 'type')->limit($limit)->get();
        return BaseResponse::success($blogs);
    }
}
