<?php

namespace App\Models;

use App\Traits\Common\Addressable;
use App\Traits\Common\Imageable;
use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model {
    use HasFactory, Addressable, Imageable, CustomScope;

    protected $fillable = [
        'name',
        'open_time',
        'close_time',
        'social_medias',
        'google_latitude',
        'google_longitude',
        'status',
        'phone',
        'email'
    ];

    protected $appends = [
        'is_open'
    ];

    protected $casts = [
        // 'open_time' => 'datetime:H:i',
    ];
    public function getIsOpenAttribute() {
        return now()->between($this->open_time, $this->close_time);
    }
}
