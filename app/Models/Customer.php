<?php

namespace App\Models;

use App\Enums\DisplayType;
use App\Enums\OrderStatus;
use App\Traits\Common\Addressable;
use App\Traits\Common\HasWishlist;
use App\Traits\Common\Imageable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\CustomerResource;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class Customer extends User {
    use HasFactory, Addressable, Imageable, SoftDeletes, CanResetPassword, Notifiable, HasApiTokens, HasWishlist;
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'phone',
        'phone_verified',
        'email',
        'status',
        'provider',
        'socialite_account_id',
        'reward_point'
    ];

    protected $appends = [
        'full_name'
    ];

    public function ranks() {
        return $this->belongsToMany(Rank::class, 'customer_ranks')->orderBy('min_value', 'desc')->withPivot('value')->withTimestamps();
    }
    public function reviews() {
        return $this->hasMany(Review::class);
    }
    public function available_ranks() {
        return $this->belongsToMany(Rank::class, 'customer_ranks')->orderBy('min_value', 'desc')
            ->whereRaw("TIMESTAMPDIFF(MONTH, customer_ranks.created_at, now()) <= ranks.cycle")->withPivot('value')->where('customer_ranks.deleted_at', null)->withTimestamps();
    }
    public function getAvailableRankAttribute() {
        return $this->available_ranks->first();
    }

    public function updateRank($delete = false) {
        $ranks = Rank::orderBy('min_value', 'desc')->get();
        foreach ($ranks as $rank) {
            $total = $this->orders()->where('order_status', OrderStatus::DELIVERED)->whereRaw("TIMESTAMPDIFF(MONTH, orders.updated_at, now()) <= $rank->cycle")->sum('subtotal');
            if ($total >= $rank->min_value) {
                CustomerRank::where('customer_id', $this->id)->delete();
                $this->ranks()->attach($rank->id, [
                    'value' => $total
                ]);
                return true;
            }
        }
        if ($delete) {
            CustomerRank::where('customer_id', $this->id)->delete();
        }
        return false;
    }

    public function otps() {
        return $this->hasMany(Otp::class);
    }

    public function cart() {
        return $this->hasOne(Cart::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function keywords() {
        return $this->hasMany(Keyword::class);
    }

    public function kiot_customer() {
        return $this->hasOne(KiotCustomer::class);
    }

    public function vouchers() {
        return $this->belongsToMany(Voucher::class, 'order_vouchers');
    }

    public function saved_vouchers() {
        return $this->belongsToMany(Voucher::class, 'customer_vouchers')->withPivot('type', 'is_used')->withTimestamps();
    }

    // public function review_voucher() {
    //     return $this->hasOneThrough(Voucher::class, CustomerVoucher::class, 'customer_id', 'id', 'id', 'voucher_id');
    // }
    public function review_vouchers() {
        return $this->belongsToMany(Voucher::class, 'customer_vouchers')->where('display', DisplayType::SYSTEM)->withPivot('type', 'is_used')->withTimestamps();
    }

    public function delivered_orders() {
        return $this->hasMany(Order::class)->where('order_status', OrderStatus::DELIVERED);
    }

    public function canceled_orders() {
        return $this->hasMany(Order::class)->where('order_status', OrderStatus::CANCELED);
    }

    public function getFullnameAttribute() {
        return "$this->last_name $this->first_name";
    }

    public function order_success_percentage() {
        $percent = $this->delivered_orders()->count() / $this->orders()->count() * 100;
        return (int) round($percent, 0);
    }

    public static function findByUserName($username) {
        return Customer::where(function ($q) use ($username) {
            $q->where('email', $username)->orWhere('phone', $username);
        })->first();
    }
    public function sendPasswordResetNotification($token) {
        $mail = $this->email;
        ResetPasswordNotification::createUrlUsing(function ($notification, $token) use ($mail) {
            // return route('client.auth.resetPassword', ['username' => $mail, 'token' => $token]);
            return env('FRONTEND_URL') . "/reset-password?username=$mail&token=$token";
        });
        $this->notify(new ResetPasswordNotification($token));
    }
    public function calculateRankDiscountAmount($amount) {
        if ($this->available_rank) {
            return $amount * $this->available_rank->benefit_value / 100;
        }
        return 0;
    }
    public function getVoucherUsed() {
        return Cache::remember("voucher_used_$this->id", 600, function () {
            return $this->vouchers()->select('vouchers.id', DB::raw('count(vouchers.id) as used_quantity'))->groupBy('vouchers.id')->whereHas('orders', function ($q) {
                $q->where('orders.order_status', '!=', OrderStatus::CANCELED)->where('orders.customer_id', $this->id);
            })->get();
        });
    }

    public function gainReviewVoucher() {
        $review_voucher = app()->get('ReviewVoucher');
        if ($review_voucher && $review_voucher->isValidTime() && $review_voucher->quantity > 0) {
            if (!$this->review_vouchers()->where('vouchers.id', $review_voucher->id)->exists()) {
                $this->review_vouchers()->sync([
                    $review_voucher->id => [
                        'is_used' => false,
                        'type' => $review_voucher->voucher_type_id
                    ]
                ], false);
                $review_voucher->update([
                    'quantity' => DB::raw('quantity - 1')
                ]);
                return $review_voucher;
            }
        }
        return null;
    }

    public function kiot_customer_by_phone() {
        return $this->hasOne(KiotCustomer::class, 'contact_number', 'phone');
    }
}
