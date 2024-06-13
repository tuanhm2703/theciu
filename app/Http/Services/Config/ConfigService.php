<?php

namespace App\Http\Services\Config;

use App\Http\Services\Customer\CustomerDataService;
use App\Models\Customer;
use App\Models\Keyword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ConfigService {
    public function increateCountKeyword(string $keyword, $count = 1) {
        Redis::incr("search_keyword:$keyword");
        Redis::zincrby("search_keyword", $count, $keyword);
    }

    public function getTrendingKeywords(): array {
        $keywords = Redis::zrevrange('search_keyword', 0, -1, ['withscores' => true]);
        return array_slice(array_keys($keywords), -10);
    }

    public function updateCustomerSearchKeywords(Customer $customer, string $keyword): void {
        $keywords = $customer->search_keywords;
        array_unshift($keywords, $keyword);
        $customer->update([
            'search_keywords' => $keywords
        ]);
        (new CustomerDataService)->addToCustomerSearchKeywords($customer, $keyword);
    }

    public function updateRedisKeywordsToDatabase() {
        $init_search_keywords = Redis::get('init_search_keywords');
        $init_search_keywords = $init_search_keywords ? json_decode($init_search_keywords) : [];
        $keywords = Redis::zrevrange('search_keyword', 0, -1, ['withscores' => true]);
        foreach($keywords as $keyword => $count) {
            $keyword = Keyword::where([
                'name' => $keyword,
            ])->first();
            if($keyword) {
                if(!in_array($keyword->name, $init_search_keywords)) {
                    $count = DB::raw("count + $count");
                }
                $keyword->update([
                    'count' => $count
                ]);
            } else {
                $keyword = Keyword::create([
                    'name' => $keyword,
                    'count' => $count
                ]);
            }
        }
        Redis::del('search_keyword');
        $keywords = Keyword::orderBy('count', 'desc')->limit(10)->get();
        Redis::set('init_search_keywords', json_encode($keyword->pluck('name')->toArray()));
        foreach($keywords as $keyword) {
            $this->increateCountKeyword($keyword->name, $keyword->count);
        }
    }
}
