<?php

namespace App\Models;

use App\Enums\VoucherDiscountType;
use App\Traits\Scopes\VoucherScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Voucher extends Model {
    use HasFactory, VoucherScope;


    protected $fillable = [
        'name',
        'discount_type',
        'code',
        'status',
        'voucher_type_id',
        'value',
        'min_order_value',
        'customer_limit',
        'quantity',
        'max_discount_amount',
        'begin',
        'end',
        'saveable',
        'featured'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'begin',
        'end'
    ];

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_vouchers')->withPivot('type')->withTimestamps();
    }

    public function customers() {
        return $this->belongsToMany(Customer::class, 'customer_vouchers')->withPivot('type', 'is_used')->withTimestamps();
    }

    public function canApplyForCustomer($customer_id) {
        return $this->orders()->where('orders.customer_id', $customer_id)->count() < $this->customer_limit && $this->quantity > 0;
    }

    public function voucher_type() {
        return $this->belongsTo(VoucherType::class);
    }

    public function getDiscountAmount($total) {
        if($this->discount_type == VoucherDiscountType::PERCENT) {
            $amount = $total * $this->value / 100;
        } else {
            $amount = $this->value;
        }
        if($this->max_discount_amount && $this->max_discount_amount < $amount) {
            $amount = $this->max_discount_amount;
        }
        return (int) $amount;
    }

    public function decreaseQuantity() {
        $this->update(['quantity' => DB::raw('quantity - 1')]);
    }

    public function increaseQuantity() {
        $this->update(['quantity' => DB::raw('quantity + 1')]);
    }

    public function getDiscountLabelAttribute() {
        if($this->discount_type == VoucherDiscountType::AMOUNT) {
            return thousandsCurrencyFormat($this->value);
        } else {
            return $this->value . "%";
        }
    }
    public function getDiscountDescriptionAttribute() {
        if(!$this->max_discount_amount) {
            return trans('labels.voucher_unlimit_discount');
        } else {
            return trans('labels.voucher_limit_discount_template', ['value' => $this->max_discount_amount]);
        }
    }
}
