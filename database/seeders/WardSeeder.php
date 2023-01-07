<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\Ward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = Province::with('districts')->get();
        foreach ($provinces as $province) {
            foreach ($province->districts as $district) {
                $str = file_get_contents(public_path("/addresses/xa-phuong/$district->code.json"));
                $wards = json_decode($str, true);
                if($wards) {
                    foreach ($wards as $ward) {
                        Ward::firstOrCreate([
                            "name" => $ward['name'],
                            "slug" => $ward['slug'],
                            "name_with_type" => $ward['name_with_type'],
                            "path" => $ward['path'],
                            "path_with_type" => $ward['path_with_type'],
                            "code" => $ward['code'],
                            "parent_id" => $district->id,
                            "type" => $ward['type'],
                        ]);
                    }
                }
            }
        }
    }
}
