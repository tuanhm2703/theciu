<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller {
    public function search(Request $request) {
        $search = $request->search;
        $tags = Tag::search('name', $search)->select(DB::raw('distinct(name) as text'), 'id')->get();
        return BaseResponse::success($tags);
    }
}
