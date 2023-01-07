<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $provinces = Province::all();
        foreach ($provinces as $province) {
            $str = file_get_contents(public_path("/addresses/quan-huyen/$province->code.json"));
            $districts = json_decode($str, true);
            foreach ($districts as $district) {
                District::firstOrCreate([
                    "name" => $district['name'],
                    "slug" => $district['slug'],
                    "name_with_type" => $district['name_with_type'],
                    "path" => $district['path'],
                    "path_with_type" => $district['path_with_type'],
                    "code" => $district['code'],
                    "parent_id" => $province->id,
                    "type" => $district['type'],
                ]);
            }
        }
    }
}
