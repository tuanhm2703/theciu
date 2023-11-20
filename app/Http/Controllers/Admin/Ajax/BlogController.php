<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Enums\BlogType;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BlogController extends Controller
{
    public function paginate(Request $request) {
        $type = $request->type ?? BlogType::WEB;
        $blogs = Blog::query()->whereType($type)->with('image');
        return DataTables::of($blogs)
        ->editColumn('status', function($blog) {
            return view('admin.pages.appearance.blog.components.status', compact('blog'));
        })
        ->editColumn('image', function($blog) {
            return view('admin.pages.appearance.blog.components.image', compact('blog'));
        })
        ->editColumn('title', function($blog) {
            return view('admin.pages.appearance.blog.components.title', compact('blog'));
        })
        ->editColumn('description', function($blog) {
            return view('admin.pages.appearance.blog.components.description', compact('blog'));
        })
        ->addColumn('action', function($blog) {
            return view('admin.pages.appearance.blog.components.action', compact('blog'));
        })
        ->make(true);
    }
}
