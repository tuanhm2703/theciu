<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request) {
        $category_name = $request->category;
        $blogs = Blog::available()->with('image', 'categories');
        if($category_name) {
            $blogs->whereHas('categories', function($q) use ($category_name){
                $q->where('categories.name', $category_name);
            });
        }
        $blogs = $blogs->paginate(8);
        return view('landingpage.layouts.pages.blog.index', compact('blogs'));
    }

    public function details($slug) {
        $blog = Blog::where('slug', $slug)->available()->with('image', 'categories')->firstOrfail();
        return view('landingpage.layouts.pages.blog.detail', compact('blog'));
    }
}
