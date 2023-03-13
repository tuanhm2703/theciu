<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Traits\Common\Addressable;
use App\Traits\Common\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\App;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\CustomerResource;

class Customer extends User {
    use HasFactory, Addressable, Imageable, SoftDeletes;
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'phone',
        'email',
        'status',
        'provider',
        'socialite_account_id'
    ];

    public function product_wishlists() {
        return $this->hasMany(Wishlist::class)->where('wishlistable_type', (new Product)->getMorphClass());
    }

    public function cart() {
        return $this->hasOne(Cart::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function kiot_customer() {
        return $this->hasOne(KiotCustomer::class);
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

    public function syncKiotInfo() {
        $customerResource = new CustomerResource(App::make(Client::class));
        if($this->phone) {
            try {
                $info = $customerResource->list(['contactNumber' => $this->phone])->toArray();
                if(count($info) > 0) {
                    $info = $info[0];
                    $this->kiot_customer()->updateOrCreate([
                        'code' => $info['code'],
                        'kiot_customer_id' => $info['id']
                    ], [
                        'total_point' => $info['totalPoint'],
                        'reward_point' => $info['rewardPoint'],
                    ]);
                    return true;
                }
            } catch (\Throwable $th) {
                \Log::info($th);
            }
        }
        return false;
    }

}
