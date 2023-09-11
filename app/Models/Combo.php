<?php

namespace App\Models;

use App\Enums\ComboStatusType;
use App\Traits\Common\CommonFunc;
use App\Traits\Scopes\ComboScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Combo extends Model
{
    use HasFactory, SoftDeletes, CommonFunc, ComboScope;
    protected $fillable = [
        'begin',
        'end',
        'name',
    ];
    protected $casts = [
        'begin' => 'datetime',
        'end' => 'datetime'
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'combo_product');
    }
    public function getStatus() {
        $status = ComboStatusType::STOPPED;
        if ($this && $this->begin && $this->end) {
            if (now()->isBetween($this->begin, $this->end)) {
                $status = ComboStatusType::HAPPENDING;
            } else if (now()->isBefore($this->begin)) {
                $status = ComboStatusType::COMMING;
            } else {
                $status = ComboStatusType::STOPPED;
            }
        }
        if (in_array($status, [ComboStatusType::COMMING, ComboStatusType::HAPPENDING]) && optional($this)->isInactive()) {
            return ComboStatusType::PAUSE;
        }
        return $status;
    }
    public function getComboStatusLabelAttribute() {
        switch ($this->getStatus()) {
            case ComboStatusType::COMMING:
                return "Sắp diễn ra";
            case ComboStatusType::HAPPENDING:
                return "Đang diễn ra";
            case ComboStatusType::STOPPED:
                return "Đã kết thúc";
            case ComboStatusType::PAUSE:
                return "Tạm dừng";
            default:
                return "Đã kết thúc";
        }
    }

    public function getComboDescriptionInProductDetails($productId) {
        $inventory = $this->products->where('id', $productId)->first()?->inventories?->first();
        $total = 0;
        if($inventory) {
            $total = $inventory->promotion_price;
            foreach($this->products->where('id', '!=', $inventory->product_id) as $product) {
                $total += $product->inventories->first()->promotion_price;
            }
        }
        $total_format = thousandsCurrencyFormat($total);
        return "Combo $this->name giá $total_format";
    }
}
