<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Traits\Common\Addressable;
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

class Customer extends User
{
    use HasFactory, Addressable, Imageable, SoftDeletes, CanResetPassword, Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'phone',
        'email',
        'status',
        'provider',
        'socialite_account_id',
        'reward_point'
    ];

    protected $appends = [
        'full_name'
    ];

    public function product_wishlists()
    {
        return $this->hasMany(Wishlist::class)->where('wishlistable_type', (new Product)->getMorphClass());
    }

    public function ranks()
    {
        return $this->belongsToMany(Rank::class, 'customer_ranks')->orderBy('min_value', 'desc')->withPivot('value')->withTimestamps();
    }

    public function available_ranks()
    {
        return $this->belongsToMany(Rank::class, 'customer_ranks')->orderBy('min_value', 'desc')
            ->whereRaw("TIMESTAMPDIFF(MONTH, customer_ranks.created_at, now()) <= ranks.cycle")->withPivot('value')->where('customer_ranks.deleted_at', null)->withTimestamps();
    }
    public function getAvailableRankAttribute()
    {
        return $this->available_ranks->first();
    }

    public function updateRank($delete = false)
    {
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
        if($delete) {
            CustomerRank::where('customer_id', $this->id)->delete();
        }
        return false;
    }



    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function keywords()
    {
        return $this->hasMany(Keyword::class);
    }

    public function kiot_customer()
    {
        return $this->hasOne(KiotCustomer::class);
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'order_vouchers');
    }

    public function saved_vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'customer_vouchers')->withPivot('type', 'is_used')->withTimestamps();
    }

    public function delivered_orders()
    {
        return $this->hasMany(Order::class)->where('order_status', OrderStatus::DELIVERED);
    }

    public function canceled_orders()
    {
        return $this->hasMany(Order::class)->where('order_status', OrderStatus::CANCELED);
    }

    public function getFullnameAttribute()
    {
        return "$this->last_name $this->first_name";
    }

    public function order_success_percentage()
    {
        $percent = $this->delivered_orders()->count() / $this->orders()->count() * 100;
        return (int) round($percent, 0);
    }

    public static function findByUserName($username)
    {
        return Customer::where(function ($q) use ($username) {
            $q->where('email', $username)->orWhere('phone', $username);
        })->first();
    }
    public function sendPasswordResetNotification($token)
    {
        $mail = $this->email;
        ResetPasswordNotification::createUrlUsing(function ($notification, $token) use ($mail) {
            return route('client.auth.resetPassword', ['username' => $mail, 'token' => $token]);
        });
        $this->notify(new ResetPasswordNotification($token));
    }
    public function calculateRankDiscountAmount($amount) {
        if($this->available_rank) {
            return $amount * $this->available_rank->benefit_value / 100;
        }
        return 0;
    }
}
