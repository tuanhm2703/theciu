<?php

namespace App\Http\Livewire\Client;

use App\Enums\CategoryType;
use App\Enums\KeywordCount;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class ProductListComponent extends Component
{
    use KeywordCount, WithPagination;

    public $title;

    public $hasNext;

    public $categories = [];

    public $product_categories;

    public $sort_type;

    public $categoryType;

    public $total;

    public $min_price;

    public $max_price;

    public $category = '';

    public $type;

    public $category_name;

    public $promotion;

    public $haspromotion;

    public $baseUrl;

    public $search_products = [];

    protected $queryString = [
        'keyword',
        'categories',
        'min_price',
        'max_price',
    ];

    protected $listeners = ['updateKeyword', 'updateKeyword'];

    public function mount()
    {
        $this->product_categories = Category::whereHas('products', function ($q) {
            $q->available();
        })->whereType(CategoryType::PRODUCT)->orderBy('categories.name')->select('id', 'name', 'slug')->withCount('products')->get();
        $this->resfreshAutocompleteKeywords();
    }
    public function render()
    {
        $products = $this->searchProduct();
        $products = $products->paginate(12)->withPath(request()->requestUri)->withQueryString()->onEachSide(3)->appends($this->getParams());
        return view('livewire.client.product-list-component', compact('products'));
    }

    private function getParams() {
        $arr = [];
        foreach ($this->queryString as $key) {
            if($this->{$key}) {
                $arr = array_merge($arr, [
                    $key => $this->{$key}
                ]);
            }
        }
        return $arr;
    }

    public function nextPage()
    {
        $this->page++;
        $this->searchProduct();
    }

    public function searchProduct($page = null)
    {
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
            $products->whereHas('promotions', function($q) {
                $q->haveNotEnded();
            });
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
        $products = $products
            ->withNeededProductCardData()
            ->orderBy('products.created_at', 'desc')->filterByPriceRange($this->min_price, $this->max_price);
        return $products;
    }

    public function clearAllFilter()
    {
        $this->categories = [];
    }

    private function searchProducts()
    {
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
            $products->haveNotEnded();
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
    // public function updated($name, $value)
    // {
    //     if ($name == 'keyword') {
    //         $this->searchProducts();
    //     }
    // }
}
