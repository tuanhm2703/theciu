<?php
namespace App\Http\Controllers\Client;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;
use Meta;

class CategoryController extends Controller
{
    public function viewCategoryTypeProduct($type) {
        $title = trans("labels.$type");
        Meta::set('title', getAppName()." - $title");
        return view('landingpage.layouts.pages.product.index', compact('type', 'title'));
    }
    public function viewProductCategory($category) {
        $category = Category::whereSlug($category)->firstOrFail();
        Meta::set('title', getAppName()." - $category->name");
        if($category->image) {
            Meta::remove('image');
            Meta::set('image', $category->image?->path_with_domain);
        };
        $category->loadMeta();
        $banners = [];
        if($category->type == CategoryType::COLLECTION) {
            $url = convertToHttps(request()->fullUrl());
            $banners = Banner::collection()->with('desktopImage', 'phoneImage')->whereUrl(request()->fullUrl())->available()->get();
        }
        $category = $category->slug;
        return view('landingpage.layouts.pages.product.index', compact('category', 'banners'));
    }
}
