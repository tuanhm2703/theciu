<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BlogListResource;
use App\Http\Resources\Api\BlogResource;
use App\Http\Resources\Api\CustomerWishlistResource;
use App\Models\Blog;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function getWishlist(Request $request) {
        $user = requestUser();
        $pageSize = $request->pageSize ?? 10;
        $blog_ids = $user->query_wishlist(Blog::class)->pluck('wishlistable_id')->toArray();
        $blogs = Blog::with('image')->select('id', 'title', 'description', 'publish_date', 'slug', 'type', 'author_name', 'thumbnail')->with('categories:name,id,slug')->whereIn('id', $blog_ids)->paginate($pageSize);
        $paginateData = $blogs->toArray();
        return BaseResponse::success([
            'items' => BlogListResource::collection($blogs),
            'total' => $paginateData['total'],
            'next_page' => $paginateData['next_page_url'],
            'prev_page' => $paginateData['prev_page_url'],
        ]);
    }
    public function addToWishlist(string $slug, Request $request) {
        $blog = Blog::whereSlug($slug)->firstOrFail();
        $user = requestUser();
        if (!$user->query_wishlist(Blog::class)->where('wishlistable_id', $blog->id)->exists()) {
            $blog->addToWishlist($user->id);
        }
        return BaseResponse::success(new CustomerWishlistResource($user));
    }

    public function removeFromWishlist(string $slug, Request $request) {
        $blog = Blog::whereSlug($slug)->firstOrFail();
        $user = requestUser();
        if (!$user->query_wishlist(Blog::class)->where('wishlistable_id', $blog->id)->exists()) {
            $blog->removeFromCustomerWishlist($user->id);
        }
        return BaseResponse::success(new CustomerWishlistResource($user));
    }
}
