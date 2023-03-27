<?php

namespace App\Observers\Kiot;

use App\Models\Customer;

class CustomerObserver
{
    public function created(Customer $customer) {
        $customer->syncKiotInfo();
    }

    public function updated(Customer $customer) {
        if($customer->isDirty('phone')) {
            $customer->syncKiotInfo();
        }
    }
}
