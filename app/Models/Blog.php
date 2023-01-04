<?php

namespace App\Models;

use App\Traits\Common\Categorizable;
use App\Traits\Common\EditedBy;
use App\Traits\Common\Imageable;
use App\Traits\Scopes\BlogScope;
use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model {
    use HasFactory, SoftDeletes, Imageable, Categorizable, BlogScope, CustomScope, EditedBy;
    protected $fillable = [
        'title',
        'description',
        'content',
        'publish_date',
        'status',
        'created_by',
        'updated_by',
        'deletd_by',
    ];
    protected $casts = [
        'publish_date' => 'datetime'
    ];
}
