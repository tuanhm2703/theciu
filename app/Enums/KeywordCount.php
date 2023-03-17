<?php

namespace App\Enums;

use App\Models\Keyword;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

trait KeywordCount
{
    public $keyword;
    public $autocompleteKeywords = [];

    public function countKeyWord($keyword)
    {
        if (Product::search('name', $keyword)->exists()) {
            $customer = customer();
            if ($customer) {
                $keyword = $customer->keywords()->firstOrCreate([
                    'name' => $keyword
                ]);
            } else {
                $keyword = Keyword::firstOrCreate([
                    'name' => $keyword,
                    'customer_id' => null
                ]);
            }
            $keyword->update([
                'count' => DB::raw('count + 1')
            ]);
        }
    }

    public function getAutocomleteKeywords($keyword)
    {
        $baseQuery = Keyword::select('name', 'count');
        $keywords = (clone $baseQuery)->search('name', $keyword)
            ->union((clone $baseQuery)->search('name', $keyword, 'binary'))
            ->union((clone $baseQuery)->where('name', $keyword))->orderBy('count', 'desc')->limit(10)->get();
        return $keywords;
    }

    public function updated($name, $value)
    {
        if ($name == 'keyword') {
            $this->resfreshAutocompleteKeywords();
        }
    }

    public function resfreshAutocompleteKeywords()
    {
        if (!empty($this->keyword)) {
            $this->countKeyWord($this->keyword);
            $this->autocompleteKeywords = $this->getAutocomleteKeywords($this->keyword);
        } else {
            $this->autocompleteKeywords = [];
        }
    }

    public function updateKeyword($keyword)
    {
        $this->keyword = $keyword;
        $this->searchProduct(1);
        $this->autocompleteKeywords = [];
    }
}
