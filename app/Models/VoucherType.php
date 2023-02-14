<?php

namespace App\Models;

use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherType extends Model {
    use HasFactory, CustomScope;
}
