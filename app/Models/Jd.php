<?php

namespace App\Models;

use App\Traits\Common\Wishlistable;
use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jd extends Model {
    use HasFactory, CustomScope, Wishlistable;

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
        'featured',
        'general_requirement',
        'position',
        'quantity',
        'working_time'
    ];
    protected $appends = [
        'time',
        'is_new',
        'is_expired'
    ];
    protected $casts = [
        'from_date' => 'datetime',
        'to_date' => 'datetime',
        'general_requirement' => 'json',
        'working_time' => 'json'
    ];

    public function getTimeAttribute() {
        return $this->from_date->format('d/m/Y H:i') . " - " . $this->to_date->format('d/m/Y H:i');
    }

    public function resumes() {
        return $this->hasMany(Resume::class);
    }
    public function scopeAvailable($q) {
        return $q->whereRaw('from_date <= NOW() AND to_date >= NOW()');
    }
    public function getIsNewAttribute() {
        return $this->from_date->diffInDays(now(), false) > 3;
    }
    public function getIsExpiredAttribute() {
        return now()->isAfter($this->to_date);
    }

    public function generateSlug() {
        $this->slug = stripVN($this->name);
        while (Jd::whereSlug($this->slug)->exists()) {
            $this->slug = stripVN($this->name);
            $code = uniqid();
            $this->slug = $this->slug . "-" . $code;
        }
        $this->save();
    }
}
