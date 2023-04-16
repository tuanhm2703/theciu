<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Meta;

class CategoryController extends Controller
{
    public function viewCategoryTypeProduct($type) {
        $title = trans("labels.$type");
        return view('landingpage.layouts.pages.product.index', compact('type', 'title'));
    }
    public function viewProductCategory($category) {
        $category = Category::whereSlug($category)->firstOrFail();
        $category->loadMeta();
        $category = $category->slug;
        return view('landingpage.layouts.pages.product.index', compact('category'));
    }
}
