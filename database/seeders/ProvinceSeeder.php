<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $str = file_get_contents(public_path('/addresses/tinh_tp.json'));
        $provinces = json_decode($str, true);
        foreach ($provinces as $province) {
            Province::firstOrCreate([
                'name' => $province['name'],
                'code' => $province['code'],
                'slug' => $province['slug'],
                "type" => $province['type'],
                'domain_code' => $province['domain_code'],
                "domain_name" => $province['domain_name'],
                'name_with_type' => $province['name_with_type']
            ]);
        }
    }
}
