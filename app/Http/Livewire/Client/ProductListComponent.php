<?php

namespace App\Http\Livewire\Client;

use App\Enums\CategoryType;
use App\Enums\KeywordCount;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ProductListComponent extends Component
{
    use KeywordCount;

    public $title;

    public $pageSize = 12;

    public $hasNext;

    public $page = 1;

    public $products;

    public $categories = [];

    public $product_categories;

    public $sort_type;

    public $categoryType;

    public $total;

    public $min_price = 0;

    public $max_price;

    public $category = '';

    public $type;

    public $category_name;

    public $promotion;

    public $haspromotion;

    public $search_products = [];

    protected $queryString = [
        'page' => ['except' => 1, 'as' => 'page'],
        'keyword',
        'categories',
        'min_price',
        'max_price',
        'category' => ['except' => '']
    ];

    protected $listeners = ['updateKeyword', 'updateKeyword'];

    public function mount()
    {
        $this->product_categories = Category::whereHas('products', function ($q) {
            $q->available();
        })->whereType(CategoryType::PRODUCT)->orderBy('categories.name')->select('id', 'name')->withCount('products')->get();
        $this->products = new Collection();
        $this->searchProduct();
        $this->resfreshAutocompleteKeywords();
    }
    public function render()
    {
        return view('livewire.client.product-list-component');
    }

    public function nextPage()
    {
        $this->page++;
        $this->searchProduct();
    }

    public function searchProduct($page = null)
    {
        if ($page) {
            $this->products = new Collection();
            $this->page = $page;
        }
        $products = Product::query();
        if ($this->category) {
            $category = Category::whereSlug($this->category)->with('categories.categories')->firstOrFail();
            $this->category_name = $category->name;
            $category_ids = $category->getAllChildId();
            $products = $products->where(function ($q) use ($category_ids) {
                $q->whereHas('other_categories', function ($q) use ($category_ids) {
                    return $q->whereIn('categories.id', $category_ids);
                })->orWhereHas('categories', function ($q) use ($category_ids) {
                    return $q->whereIn('categories.id', $category_ids);
                });
            });
        }
        if ($this->haspromotion) {
            $products->hasAvailablePromotions();
        }
        if ($this->promotion) {
            $products->whereHas('promotions', function ($q) {
                $q->where('promotions.id', $this->promotion->id);
            });
        }
        if ($this->type) {
            $products->whereHas('other_categories', function ($q) {
                $q->where('categories.type', $this->type);
            });
        }
        if (!empty($this->keyword)) {
            $products->search('products.name', $this->keyword);
        }
        $this->total = (clone $products)->filterByPriceRange($this->min_price, $this->max_price)->count();
        $products = $products
            ->withNeededProductCardData()
            ->filterByPriceRange($this->min_price, $this->max_price)
            ->with(['inventories.image:path,imageable_id', 'images:path,imageable_id'])
            ->getPage($this->page, $this->pageSize)->get();
        $this->products = $this->products->merge($products);
        $this->hasNext = $this->products->count() < $this->total;
    }

    public function clearAllFilter()
    {
        $this->categories = [];
        $this->searchProduct(1);
    }

    private function searchProducts() {
        $products = Product::query();
        if ($this->category) {
            $category = Category::whereSlug($this->category)->with('categories.categories')->firstOrFail();
            $this->category_name = $category->name;
            $category_ids = $category->getAllChildId();
            $products = $products->where(function ($q) use ($category_ids) {
                $q->whereHas('other_categories', function ($q) use ($category_ids) {
                    return $q->whereIn('categories.id', $category_ids);
                })->orWhereHas('categories', function ($q) use ($category_ids) {
                    return $q->whereIn('categories.id', $category_ids);
                });
            });
        }
        if ($this->haspromotion) {
            $products->hasAvailablePromotions();
        }
        if ($this->promotion) {
            $products->whereHas('promotions', function ($q) {
                $q->where('promotions.id', $this->promotion->id);
            });
        }
        if ($this->type) {
            $products->whereHas('other_categories', function ($q) {
                $q->where('categories.type', $this->type);
            });
        }
        if (!empty($this->keyword)) {
            $products->search('products.name', $this->keyword);
        }
        $this->total = (clone $products)->filterByPriceRange($this->min_price, $this->max_price)->count();
        $this->search_products = $products->select('products.name', 'products.slug', 'products.id')
            ->filterByPriceRange($this->min_price, $this->max_price)
            ->with(['inventories.image:path,imageable_id', 'images:path,imageable_id'])->limit(15)->get();
    }
    public function updated($name, $value)
    {
        if ($name == 'keyword') {
            $this->searchProducts();
        }
    }
}
