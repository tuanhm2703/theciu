<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductBatchImport implements ToCollection {
    use Importable;
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection) {
        //
    }
}
