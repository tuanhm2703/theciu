<?php

namespace App\Models;

use App\Traits\Common\Imageable;
use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model {
    use HasFactory, Imageable, CustomScope;

    public function canUse($value) {
        $min_value = $this->min_value == null ? 0 : $this->min_value;
        $max_value = $this->max_value == null ? INF : $this->max_value;
        return ($min_value <= $value && $max_value >= $value);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}
