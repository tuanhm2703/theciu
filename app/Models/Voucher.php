<?php

namespace App\Models;

use App\Enums\DisplayType;
use App\Enums\VoucherDiscountType;
use App\Traits\Scopes\CustomScope;
use App\Traits\Scopes\VoucherScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Voucher extends Model {
    use HasFactory, VoucherScope, CustomScope;


    protected $fillable = [
        'name',
        'discount_type',
        'total_quantity',
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
        'featured',
        'display',
        'total_can_use',
        'for_new_customer'
    ];

    protected $casts = [
        'begin' => 'datetime:Y-m-d H:i:s',
        'end' => 'datetime:Y-m-d H:i:s',
    ];

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_vouchers')->withPivot('type')->withTimestamps();
    }

    public function customers() {
        return $this->belongsToMany(Customer::class, 'customer_vouchers')->withPivot('type', 'is_used')->withTimestamps();
    }

    public function canApplyForCustomer($customer_id) {
        $customer = Customer::find($customer_id);
        if ($customer) {
            $voucher_used = $customer->getVoucherUsed();
            $data = $voucher_used->where('id', $this->id)->first();
            if ($data) {
                return $data->used_quantity < $this->customer_limit && $this->quantity > 0;
            }
        }
        return true;
    }

    public function voucher_type() {
        return $this->belongsTo(VoucherType::class);
    }

    public function getDiscountAmount($total) {
        if ($this->discount_type == VoucherDiscountType::PERCENT) {
            $amount = $total * $this->value / 100;
        } else {
            $amount = $this->value;
        }
        if ($this->max_discount_amount && $this->max_discount_amount < $amount) {
            $amount = $this->max_discount_amount;
        }
        return (int) $amount;
    }

    public function decreaseQuantity(Customer $customer) {
        if ($this->saveable) {
            $customer->saved_vouchers()->sync([
                $this->id => [
                    'is_used' => true
                ]
            ], false);
        } else {
            $this->update(['quantity' => DB::raw('quantity - 1')]);
        }
    }

    public function increaseQuantity(Customer $customer) {
        if ($this->saveable) {
            $customer->saved_vouchers()->sync([
                $this->id => [
                    'is_used' => false
                ]
            ], false);
        } else {
            $this->update(['quantity' => DB::raw('quantity + 1')]);
        }
    }

    public function getDiscountLabelAttribute() {
        if ($this->discount_type == VoucherDiscountType::AMOUNT) {
            return "Giảm " . thousandsCurrencyFormat($this->value);
        } else {
            if ($this->voucher_type->code == VoucherType::FREESHIP && $this->value == 100) return 'FREESHIP';
            return "Giảm " . $this->value . "%";
        }
    }
    public function getDiscountDescriptionAttribute() {
        if (!$this->max_discount_amount) {
            return trans('labels.voucher_unlimit_discount');
        } else {
            return trans('labels.voucher_limit_discount_template', ['value' => format_currency_with_label($this->max_discount_amount)]);
        }
    }

    public function getDetailInfoAttribute() {
        return "$this->discount_description Áp dụng đến " . $this->end->format('d/m/Y H:i') . ". Mỗi tài khoản được sử dụng $this->customer_limit lần.";
    }
    public function isValidTime() {
        return now()->between($this->begin, $this->end);
    }
    public function isPrivate() {
        return $this->display === DisplayType::PRIVATE;
    }
    public function isSystem() {
        return $this->display === DisplayType::SYSTEM;
    }
}
