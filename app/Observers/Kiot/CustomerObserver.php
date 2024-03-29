<?php

namespace App\Observers\Kiot;

use App\Models\Customer;
use App\Services\KiotService;

class CustomerObserver
{
    public function created(Customer $customer) {
        if($customer->phone) {
            (new KiotService)->syncKiotInfo($customer);
        }
    }

    public function updated(Customer $customer) {
        if($customer->isDirty('phone')) {
            (new KiotService)->syncKiotInfo($customer);
        }
    }
}
