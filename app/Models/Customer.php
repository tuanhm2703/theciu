<?php

namespace App\Models;

use App\Traits\Common\Addressable;
use App\Traits\Common\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Customer extends User {
    use HasFactory, Addressable, Imageable;
}
