<?php

namespace Database\Seeders;

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
        DB::statement("INSERT INTO `argon`.`addresses` (`id`, `addressable_type`, `addressable_id`, `type`, `details`, `province_id`, `district_id`, `ward_id`, `full_address`, `fullname`, `phone`, `created_at`, `updated_at`, `featured`, `deleted_at`) VALUES (52, 'App\\Models\\Config', 1, 'pickup', '285/24 Đường Cách Mạng Tháng 8', 1, 10, 146, '285/24 Đường Cách Mạng Tháng 8, Phường 12, Quận 10, Thành phố Hồ Chí Minh', 'THE CIU KHO ONLINE', '0775665912', '2023-01-26 22:09:48', '2023-01-26 22:09:48', 0, NULL);
        INSERT INTO `argon`.`addresses` (`id`, `addressable_type`, `addressable_id`, `type`, `details`, `province_id`, `district_id`, `ward_id`, `full_address`, `fullname`, `phone`, `created_at`, `updated_at`, `featured`, `deleted_at`) VALUES (51, 'App\\Models\\Config', 1, 'pickup', '73 Đường Nguyễn Văn Bảo', 1, 3, 32, '73 Đường Nguyễn Văn Bảo, Phường 4, Quận Gò Vấp, Thành phố Hồ Chí Minh', 'THE CIU Nguyễn Văn Bảo', '0707987912', '2023-01-26 22:08:48', '2023-01-26 22:08:48', 0, NULL);
        INSERT INTO `argon`.`addresses` (`id`, `addressable_type`, `addressable_id`, `type`, `details`, `province_id`, `district_id`, `ward_id`, `full_address`, `fullname`, `phone`, `created_at`, `updated_at`, `featured`, `deleted_at`) VALUES (50, 'App\\Models\\Config', 1, 'pickup', '50 Tô Vĩnh Diện', 1, 8, 104, '50 Tô Vĩnh Diện, Phường Linh Chiểu, Thành phố Thủ Đức, Thành phố Hồ Chí Minh', 'THE CIU Tô Vĩnh Diện', '0333707912', '2023-01-26 22:08:16', '2023-01-26 22:08:16', 0, NULL);
        INSERT INTO `argon`.`addresses` (`id`, `addressable_type`, `addressable_id`, `type`, `details`, `province_id`, `district_id`, `ward_id`, `full_address`, `fullname`, `phone`, `created_at`, `updated_at`, `featured`, `deleted_at`) VALUES (49, 'App\\Models\\Config', 1, 'pickup', '680 Sư Vạn Hạnh', 1, 10, 148, '680 Sư Vạn Hạnh, Phường 10, Quận 10, Thành phố Hồ Chí Minh', 'THE CIU Sư Vạn Hạnh', '0707358912', '2023-01-26 22:04:13', '2023-01-26 22:04:13', 0, NULL);
        INSERT INTO `argon`.`addresses` (`id`, `addressable_type`, `addressable_id`, `type`, `details`, `province_id`, `district_id`, `ward_id`, `full_address`, `fullname`, `phone`, `created_at`, `updated_at`, `featured`, `deleted_at`) VALUES (48, 'App\\Models\\Config', 1, 'pickup', '29/0 Đường Nguyễn Gia Trí', 1, 4, 43, '29/0 Đường Nguyễn Gia Trí, Phường 25, Quận Bình Thạnh, Thành phố Hồ Chí Minh', 'THE CIU D2', '0901246912', '2023-01-26 21:50:21', '2023-01-26 21:50:21', 1, NULL);");
    }
}
