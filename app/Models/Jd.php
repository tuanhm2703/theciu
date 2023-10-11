<?php

namespace App\Models;

use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jd extends Model
{
    use HasFactory, CustomScope;

    protected $table = 'jds';
    protected $fillable = [
        'name',
        'group',
        'job_type',
        'from_date',
        'to_date',
        'status',
        'short_description',
        'description',
        'requirement',
        'benefit',
    ];
    protected $appends = [
        'time'
    ];
    protected $casts = [
        'from_date' => 'datetime',
        'to_date' => 'datetime'
    ];

    public function getTimeAttribute() {
        return "$this->from_date - $this->to_date";
    }

    public function resumes() {
        return $this->hasMany(Resume::class);
    }
}
