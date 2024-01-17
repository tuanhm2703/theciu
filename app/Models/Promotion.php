<?php

namespace App\Models;

use App\Enums\PromotionStatusType;
use App\Traits\Common\CommonFunc;
use App\Traits\Scopes\CustomScope;
use App\Traits\Scopes\PromotionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Promotion extends Model {
    use HasFactory, CustomScope, CommonFunc, PromotionScope, SoftDeletes;

    protected $fillable = [
        'name',
        'from',
        'to',
        'status',
        'type',
        'slug',
        'updated_at',
        'min_order_value'
    ];

    protected $casts = [
        'from' => 'datetime',
        'to' => 'datetime'
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'promotion_product')->withPivot([
            'promotion_id',
            'product_id',
            'featured'
        ]);
    }

    public function generateUniqueSlug() {
        $base_slug = stripVN($this->name);
        $slug = $base_slug;
        while (Category::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = "$base_slug-" . now()->timestamp;
        }
        return $slug;
    }

    public function getTimeLeftAttribute() {
        return $this->to->diffInSeconds(now());
    }

    public function getStatus() {
        $status = PromotionStatusType::STOPPED;
        if ($this && $this->from && $this->to) {
            if (now()->isBetween($this->from, $this->to)) {
                $status = PromotionStatusType::HAPPENDING;
            } else if (now()->isBefore($this->from)) {
                $status = PromotionStatusType::COMMING;
            } else {
                $status = PromotionStatusType::STOPPED;
            }
        }
        if (in_array($status, [PromotionStatusType::COMMING, PromotionStatusType::HAPPENDING]) && optional($this)->isInactive()) {
            return PromotionStatusType::PAUSE;
        }
        return $status;
    }

    public function getPromotionStatusLabelAttribute() {
        switch ($this->getStatus()) {
            case PromotionStatusType::COMMING:
                return "Sắp diễn ra";
            case PromotionStatusType::HAPPENDING:
                return "Đang diễn ra";
            case PromotionStatusType::STOPPED:
                return "Đã kết thúc";
            case PromotionStatusType::PAUSE:
                return "Tạm dừng";
            default:
                return "Đã kết thúc";
        }
    }
}
