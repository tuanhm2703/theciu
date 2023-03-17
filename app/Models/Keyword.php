<?php

namespace App\Models;

use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory, CustomScope;

    protected $fillable = [
        'customer_id',
        'name',
        'count'
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }
}
