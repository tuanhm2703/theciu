<?php

namespace App\Http\Controllers\Api;

use App\Enums\BlogType;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request) {
        $type = $request->type ?? BlogType::WEB;
        $pageSize = $request->pageSize ?? 9;
        $blogs = Blog::with('image')->select('title', 'description', 'publish_date', 'slug', 'type')->whereType($type)->paginate($pageSize);
        return BaseResponse::success($blogs);
    }

    public function detail($slug) {
        $blog = Blog::whereSlug($slug)->with('image')->firstOrFail();
        return BaseResponse::success($blog);
    }

}
