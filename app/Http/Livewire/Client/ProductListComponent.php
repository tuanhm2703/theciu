<?php

namespace App\Http\Livewire\Client;

use App\Enums\CategoryType;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ProductListComponent extends Component {
    public $keyword;

    public $title;

    public $type;

    public $pageSize = 8;

    public $hasNext;

    public $page = 1;

    public $products;

    public $categories = [];
    public $product_categories;

    public $sort_type;

    public $min_price = 0;
    public $max_price;

    public $promotion;
    public $category = '';

    protected $queryString = [
        'page' => ['except' => 1, 'as' => 'page'],
        'keyword',
        'categories',
        'min_price',
        'max_price',
        'category' => ['except' => ''],
        'promotion'
    ];

    public function mount() {
        $this->product_categories = Category::whereType(CategoryType::PRODUCT)->select('id', 'name')->withCount('products')->get();
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
        $this->title = null;
        $this->type = null;
        $products = Product::query();
        if ($this->category) {
            $category = Category::whereSlug($this->category)->with('categories.categories')->firstOrFail();
            $category_ids = $category->getAllChildId();
            $this->title = $category->name;
            $this->type = 'Danh mục';
            $products = Product::whereHas('categories', function ($q) use ($category_ids) {
                return $q->whereIn('categories.id', $category_ids);
            });
        }
        if ($this->promotion) {
            $promotion = Promotion::whereSlug($this->promotion)->first();
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
        ->filterByPriceRange($this->min_price, $this->max_price)
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
