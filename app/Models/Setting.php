<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'data'
    ];

    protected $casts = [
        'data' => 'json'
    ];

    public static function getKiotSetting() {
        return Setting::firstOrCreate([
            'name' => 'kiotviet_config'
        ], [
            'data' => [
                'branchId' => null
            ]
        ]);
    }
    public static function getWebsiteSetting() {
        return Setting::firstOrCreate([
            'name' => 'website_setting'
        ], [
            'data' => [
                'header_code' => '',
                'footer_code' => ''
            ]
        ]);
    }
    public static function getReviewVoucher() {
        $setting = Setting::firstOrCreate([
            'name' => 'review_voucher'
        ], [
            'data' => ""
        ]);
        return Voucher::find($setting->data);
    }

    public static function getShopeeSettings() {
        return Setting::firstOrCreate([
            'name' => 'shopee'
        ], [
            'data' => ""
        ]);
    }

    public static function getShopeeAccessToken() {
        return Setting::firstOrCreate([
            'name' => 'shopee_access_token'
        ], [
            'data' => ""
        ]);
    }

    public static function getShopeeRefreshToken() {
        return Setting::firstOrCreate([
            'name' => 'shopee_refresh_token'
        ], [
            'data' => ""
        ]);
    }
    public static function getShopeeShopid() {
        return Setting::firstOrCreate([
            'name' => 'shopee_shop_id'
        ], [
            'data' => ""
        ]);
    }
}
