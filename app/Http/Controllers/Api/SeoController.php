<?php

namespace App\Http\Controllers\Api;

use App\Exports\ProductSeoExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SeoController extends Controller
{
    public function getProductExcelFile() {
        return Excel::download(new ProductSeoExport, 'product-seo.xlsx');
    }
}
