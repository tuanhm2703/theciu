<?php

namespace App\Http\Livewire\Client;

use App\Enums\CategoryType;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ProductListComponent extends Component {
    public $params;

    public $keyword;

    public $title;

    public $type;

    public $pageSize;

    public $hasNext;

    public $page = 1;

    public $products;

    public $categories;
    public $product_categories;

    public $sort_type;

    protected $queryString = [
        'page' => ['except' => 1, 'as' => 'page'],
        'keyword',
        'categories'
    ];

    public function mount() {
        $this->product_categories = Category::whereType(CategoryType::PRODUCT)->select('id', 'name')->withCount('products')->get();
        $this->pageSize = $this->params['pageSize'] ?? 8;
        $this->page = $this->params['page'] ?? 1;
        $this->products = new Collection();
        $this->searchProduct();
    }
    public function render() {
        return view('livewire.client.product-list-component');
    }

    public function nextPage() {
        $this->page++;
        $this->searchProduct();
    }

    public function searchProduct($page = null) {
        if($page) {
            $this->products = new Collection();
            $this->page = $page;
        }
        $category = optional($this->params)['category'];
        $promotion = optional($this->params)['promotion'];
        $this->title = null;
        $this->type = null;
        $products = Product::query();
        if ($category) {
            $category = Category::whereSlug($category)->with('categories.categories')->firstOrFail();
            $category_ids = $category->getAllChildId();
            $this->title = $category->name;
            $this->type = 'Danh mục';
            $products = Product::whereHas('categories', function ($q) use ($category_ids) {
                return $q->whereIn('categories.id', $category_ids);
            });
        }
        if ($promotion) {
            $promotion = Promotion::whereSlug($promotion)->first();
            if ($promotion) {
                $promotion = $products->whereHas('promotions', function ($q) use ($promotion) {
                    $q->where('promotions.slug', $promotion->slug);
                })->firstOrFail();
                $this->title = $promotion->name;
                $this->type = 'Chương trình';
            }
        }
        if(!empty($this->keyword)) {
            $products->search('name', $this->keyword);
        }
        if(!empty($this->categories)) {
            $products->whereHas('categories', function($q) {
                $q->whereIn('categories.id', $this->categories);
            });
        }
        $total = (clone $products)->count();
        $products = $products->select('products.name', 'products.slug', 'products.id')
        ->with(['inventories.image:path,imageable_id', 'images:path,imageable_id'])
        ->getPage($this->page, $this->pageSize)->get();
        $this->products = $this->products->merge($products);
        $this->hasNext = $this->products->count() < $total;
    }

    public function clearAllFilter() {
        $this->categories = [];
        $this->searchProduct(1);
    }
}
