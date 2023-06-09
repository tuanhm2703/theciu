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

    public $category;

    public $products;

    public $product_categories;

    public $sort_type;

    public $total;

    public $min_price = 0;

    public $max_price;

    public $promotion;

    protected $queryString = [
        'page' => ['except' => 1, 'as' => 'page'],
        'keyword',
        'category',
        'min_price',
        'max_price',
    ];

    public function mount() {
        $this->product_categories = Category::whereHas('products', function($q) {
            $q->available();
        })->whereType(CategoryType::PRODUCT)->select('id', 'name')->withCount('products')->get();
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
            $q->haveNotEnded();
            if($this->promotion) {
                $q->where('promotions.id', $this->promotion->id);
            }
        });

        if (!empty($this->keyword)) {
            $products->search('products.name', $this->keyword);
        }
        $category_ids = [];
        if ($this->category) {
            $category = Category::whereSlug($this->category)->with('categories.categories')->firstOrFail();
            $category_ids = $category->getAllChildId();
            $products = $products->where(function ($q) use ($category_ids) {
                $q->whereHas('other_categories', function ($q) use ($category_ids) {
                    return $q->whereIn('categories.id', $category_ids);
                })->orWhereHas('categories', function ($q) use ($category_ids) {
                    return $q->whereIn('categories.id', $category_ids);
                });
            });
        }
        $products->select('products.name', 'products.slug', 'products.id')
        ->filterByPriceRange($this->min_price, $this->max_price);
        $this->total = (clone $products)->count();
        $products = $products
            ->with(['inventories.image:path,imageable_id', 'images:path,imageable_id'])
            ->getPage($this->page, $this->pageSize)->get();
        $this->products = $this->products->merge($products);
        $this->hasNext = $this->products->count() < $this->total;
    }

    public function clearAllFilter() {
        $this->searchProduct(1);
    }
}
