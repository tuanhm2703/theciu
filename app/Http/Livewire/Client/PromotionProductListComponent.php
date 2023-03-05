<?php

namespace App\Http\Livewire\Client;

use App\Enums\CategoryType;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class PromotionProductListComponent extends Component {
    public $keyword;

    public $title;

    public $type;

    public $pageSize = 9;

    public $hasNext;

    public $page = 1;

    public $products;

    public $categories = [];

    public $product_categories;

    public $sort_type;

    public $total;

    public $min_price = 0;

    public $max_price;

    public $promotion;

    protected $queryString = [
        'page' => ['except' => 1, 'as' => 'page'],
        'keyword',
        'categories',
        'min_price',
        'max_price',
    ];

    public function mount() {
        $this->product_categories = Category::whereType(CategoryType::PRODUCT)->select('id', 'name')->withCount('products')->get();
        $this->products = new Collection();
        $this->searchProduct();
    }
    public function render() {
        return view('livewire.client.promotion-product-list-component');
    }
    public function nextPage() {
        $this->page++;
        $this->searchProduct();
    }

    public function searchProduct($page = null) {
        if ($page) {
            $this->products = new Collection();
            $this->page = $page;
        }
        $products = Product::query()->whereHas('promotions', function($q) {
            $q->available();
            if($this->promotion) {
                $q->where('promotions.id', $this->promotion->id);
            }
        });

        if (!empty($this->keyword)) {
            $products->search('products.name', $this->keyword);
        }
        if (!empty($this->categories)) {
            $products->whereHas('categories', function ($q) {
                $q->whereIn('categories.id', $this->categories);
            });
        }
        $this->total = (clone $products)->filterByPriceRange($this->min_price, $this->max_price)->count();
        $products = $products->select('products.name', 'products.slug', 'products.id')
            ->filterByPriceRange($this->min_price, $this->max_price)
            ->with(['inventories.image:path,imageable_id', 'images:path,imageable_id'])
            ->getPage($this->page, $this->pageSize)->get();
        $this->products = $this->products->merge($products);
        $this->hasNext = $this->products->count() < $this->total;
    }

    public function clearAllFilter() {
        $this->categories = [];
        $this->searchProduct(1);
    }
}
