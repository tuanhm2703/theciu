<?php

namespace Database\Seeders;

use App\Enums\SettingKey;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeoSettingSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Setting::updateOrCreate([
            'name' => SettingKey::SEO
        ], [
            'data' => [
                ['name' => 'Meta-title', 'data' => 'Thời trang nữ THE CIU - 1000+ mẫu quần áo hot trend Hàn Quốc'],
                ['name' => 'Meta-description', 'data' => 'Thời trang nữ THE CIU mang phong cách trẻ trung, năng động. Chuyên sản phẩm kết hợp đi học, đi chơi như áo thun, áo khoác, quần jean, đầm, chân váy'],
            ]
        ]);
    }
}
