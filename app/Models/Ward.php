<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "slug",
        "name_with_type",
        "path",
        "path_with_type",
        "code",
        'parent_id',
        "type",
        "support_type",
    ];

    public function district() {
        return $this->belongsTo(District::class, 'parent_id');
    }
}
