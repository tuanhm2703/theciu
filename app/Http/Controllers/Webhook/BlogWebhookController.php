<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Http\Services\Blog\BlogService;
use Illuminate\Http\Request;

class BlogWebhookController extends Controller
{
    public function webhook(Request $request) {
        try {
            if($request->post_publish_id) {
                (new BlogService())->syncByBlogId($request->post_publish_id);
            } else if ($request->post_id_trashed) {
                (new BlogService())->deleteLocalBlogByApiBlogId($request->post_id_trashed);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json([
            'message' => 'success'
        ]);
    }
}
