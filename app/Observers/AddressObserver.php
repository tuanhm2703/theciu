<?php

namespace App\Observers;

use App\Models\Address;

class AddressObserver {
    public function creating(Address $address) {
        $address->full_address = $address->details . ", " . $address->ward->path_with_type;
    }

    public function updating(Address $address) {
        $address->full_address = $address->details . ", " . $address->ward->path_with_type;
    }
}
