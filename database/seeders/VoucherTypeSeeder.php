<?php

namespace Database\Seeders;

use App\Models\VoucherType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherTypeSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        VoucherType::firstOrCreate([
            'code' => 'ORDER'
        ], [
            'name' => 'Đơn hàng'
        ]);
        VoucherType::firstOrCreate([
            'code' => 'FREESHIP'
        ], [
            'name' => 'Vận chuyển'
        ]);
    }
}
