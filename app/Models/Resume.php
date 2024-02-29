<?php

namespace App\Models;

use App\Traits\Common\Imageable;
use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model {
    use HasFactory, CustomScope, Imageable;

    protected $fillable = [
        'fullname',
        'phone',
        'email',
        'birthday',
        'self_introduce',
        'strength',
        'question',
        'expected_salary'
    ];

    public function jd() {
        return $this->belongsTo(Jd::class);
    }
}
