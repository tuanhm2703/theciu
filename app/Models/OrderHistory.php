<?php

namespace App\Models;

use App\Traits\Common\Actionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model {
    use HasFactory, Actionable;
}
