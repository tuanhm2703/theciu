<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PickupAddressSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $config = Config::firstOrCreate();
        $config->pickup_addresses()->create([
            'type' =>'pickup',
            'details'=> '285/24 Đường Cách Mạng Tháng 8',
            'province_id' => 1,
            'district_id' => 10,
            'ward_id' => 146,
            'full_address' => '285/24 Đường Cách Mạng Tháng 8, Phường 12, Quận 10, Thành phố Hồ Chí Minh',
            'fullname' => 'THE CIU KHO ONLINE',
            'phone' => '0775665912',
            'featured' => 1
        ]);
        $config->pickup_addresses()->create([
            'type' =>'pickup',
            'details'=> '73 Đường Nguyễn Văn Bảo',
            'province_id' => 1,
            'district_id' => 3,
            'ward_id' => 32,
            'full_address' => '73 Đường Nguyễn Văn Bảo, Phường 4, Quận Gò Vấp, Thành phố Hồ Chí Minh',
            'fullname' => 'THE CIU Nguyễn Văn Bảo',
            'phone' => '0707987912',
            'featured' => 0
        ]);
        $config->pickup_addresses()->create([
            'type' =>'pickup',
            'details'=> '50 Tô Vĩnh Diện',
            'province_id' => 1,
            'district_id' => 8,
            'ward_id' => 104,
            'full_address' => '50 Tô Vĩnh Diện, Phường Linh Chiểu, Thành phố Thủ Đức, Thành phố Hồ Chí Minh',
            'fullname' => 'THE CIU Tô Vĩnh Diện',
            'phone' => '0775665912',
            'featured' => 0
        ]);


        $config->pickup_addresses()->create([
            'type' =>'pickup',
            'details'=> '29/0 Đường Nguyễn Gia Trí',
            'province_id' => 1,
            'district_id' => 10,
            'ward_id' => 146,
            'full_address' => '285/24 Đường Cách Mạng Tháng 8, Phường 12, Quận 10, Thành phố Hồ Chí Minh',
            'fullname' => 'THE CIU KHO ONLINE',
            'phone' => '0775665912',
            'featured' => 0
        ]);
        $config->pickup_addresses()->create([
            'type' =>'pickup',
            'details'=> '680 Sư Vạn Hạnh',
            'province_id' => 1,
            'district_id' => 4,
            'ward_id' => 43,
            'full_address' => '29/0 Đường Nguyễn Gia Trí, Phường 25, Quận Bình Thạnh, Thành phố Hồ Chí Minh',
            'fullname' => 'THE CIU D2',
            'phone' => '0901246912',
            'featured' => 0
        ]);
    }
}
