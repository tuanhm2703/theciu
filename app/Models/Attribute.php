<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Scopes\CustomScope;

class Attribute extends Model {
    use HasFactory, SoftDeletes, CustomScope;

    protected $fillable = [
        'name'
    ];
    protected $appends = [
        'encode_value'
    ];

    public function inventories() {
        return $this->belongsToMany(Inventory::class);
    }
    public function getEncodeValueAttribute() {
        return stripVN($this->value);
}
}
