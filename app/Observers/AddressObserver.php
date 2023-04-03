<?php

namespace App\Observers;

use App\Models\Address;
use App\Models\Ward;

class AddressObserver {
    public function creating(Address $address) {
        $address->full_address = $address->details . ", " . $address->ward->path_with_type;
    }

    public function updating(Address $address) {
        $ward = Ward::find($address->ward_id);
        $address->full_address = $address->details . ", " . $ward->path_with_type;
    }
}
