<?php

namespace App\Models;

use App\Traits\Common\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory, Imageable;

    protected $fillable = [
        'name',
        'min_value',
        'benefit_value',
        'cycle'
    ];

    public function customers() {
        return $this->belongsToMany(Customer::class, 'customer_ranks')->where('customer_ranks.deleted_at', null);
    }
}
