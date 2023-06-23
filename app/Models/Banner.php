<?php

namespace App\Models;

use App\Traits\Common\Imageable;
use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model {
    use HasFactory, SoftDeletes, Imageable, CustomScope;
    protected $fillable = [
        'title',
        'description',
        'url',
        'order',
        'status'
    ];
    public function getImageSizesAttribute() {
        return [
            1600
        ];
    }
}
