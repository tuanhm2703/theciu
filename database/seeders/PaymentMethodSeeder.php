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
        $cod = PaymentMethod::updateOrCreate([
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
        $cod->createImagesFromUrls([public_path('/img/cod.png')]);

        $momo = PaymentMethod::updateOrCreate([
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
        $atm = PaymentMethod::updateOrCreate([
            'name' => 'Momo ATM'
        ], [
            'status' => StatusType::ACTIVE,
            'code' => 'ebank',
            'description' => 'Thanh toán banking thông qua ví điện tử Momo',
            'type' => PaymentMethodType::EBANK,
            'min_value' => null,
            'max_value' => null,
        ]);
        $atm->images()->delete();
        $atm->createImagesFromUrls(['https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png']);
        $vnpay = PaymentMethod::updateOrCreate([
            'name' => 'VNPay'
        ], [
            'status' => StatusType::ACTIVE,
            'code' => 'vnpay',
            'description' => 'Thanh toán thông qua ví điện tử VNPay: Đơn hàng tối thiểu 5.000đ - Đơn hàng tối đa 5.000.000đ',
            'type' => PaymentMethodType::EWALLET,
            'min_value' => 5000,
            'max_value' => 5000000,
        ]);
        $vnpay->images()->delete();
        $vnpay->createImagesFromUrls(['https://inkythuatso.com/uploads/images/2021/12/vnpay-logo-inkythuatso-01-13-16-26-42.jpg']);
    }
}
