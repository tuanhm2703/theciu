<?php

namespace App\Http\Services\Customer;

use App\Enums\CustomerDataKey;
use App\Models\Customer;
use App\Models\CustomerData;

class CustomerDataService {
    public function addToCustomerSearchKeywords(Customer $customer, $keyword) {
        $data = CustomerData::firstOrCreate([
            'customer_id' => $customer->id,
            'key' => CustomerDataKey::ALL_SEARCH_KEY
        ]);
        $keywords = $data->data ? $data->data : [];
        $keywords[] = $keyword;
        $data->update([
            'data' => array_unique($keywords)
        ]);
    }
}
