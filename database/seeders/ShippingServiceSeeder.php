<?php

namespace Database\Seeders;

use App\Enums\ShippingServiceType;
use App\Models\ShippingService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingServiceSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        ShippingService::firstOrCreate([
            'name' => 'Giao hàng tiết kiệm',
            'alias' => ShippingServiceType::GIAO_HANG_TIET_KIEM_ALIAS,
            'token' => env('APP_ENV') == 'prod' ? '01e068467D24942a3b79b6881257f7E4334019fa' : 'e98546066d9C895Aabdf65f367984E536d3e57b8',
            'domain' => env('APP_ENV') == 'prod' ? 'https://services.giaohangtietkiem.vn' : 'https://services-staging.ghtklab.com',
            'logo_address' => 'https://img.decloset.vn/dec-prod/images/origins/giao-hang-tiet-kiem.jpg',
            'default' => 0,
            'active' => 1,
            'ip_address' => env('APP_ENV') == 'prod' ? '58.186.206.12' : '58.186.206.11'
        ]);
    }
}
