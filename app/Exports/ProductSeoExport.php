<?php

namespace App\Exports;

use App\Models\Product;
use App\Services\StorageService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductSeoExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $domain = env('APP_URL');
        $bucket = StorageService::url('');
        return Product::available()->select('products.id', 'products.name', DB::raw("concat('$domain/product/', products.slug)"))
        ->leftJoin('images', function($q) {
            $q->on('images.imageable_id', 'products.id')->where('images.imageable_type', (new Product)->getMorphClass())->where(function($q) {
                $q->where('images.order', 0)->orWhere('images.order', null);
            });
        })
        ->addSalePrice()
        ->addSelect(DB::raw("concat('$bucket', images.path)"))
        ->groupBy('products.name')
        ->get();
    }
}
