<?php

namespace Database\Seeders;

use App\Enums\PaymentMethodType;
use App\Enums\StatusType;
use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $cod = PaymentMethod::firstOrCreate([
            'name' => 'Cash on delivery',
        ], [
            'status' => StatusType::ACTIVE,
            'code' => 'cod',
            'type' => PaymentMethodType::COD,
            'description' => 'Thanh toán khi nhận hàng',
            'min_value' => null,
            'max_value' => null,
        ]);
        $cod->images()->delete();
        $cod->createImagesFromUrls(['https://cdn-icons-png.flaticon.com/512/5229/5229335.png']);
        $momo = PaymentMethod::firstOrCreate([
            'name' => 'Momo'
        ], [
            'status' => StatusType::ACTIVE,
            'code' => 'momo',
            'description' => 'Thanh toán thông qua ví điện tử Momo: Đơn hàng tối thiểu 100đ - Đơn hàng tối đa 2.000.000đ',
            'type' => PaymentMethodType::EWALLET,
            'min_value' => 100,
            'max_value' => 2000000,
        ]);
        $momo->images()->delete();
        $momo->createImagesFromUrls(['https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png']);
    }
}
