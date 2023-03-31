<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vip = Rank::firstOrCreate([
            'name' => 'VIP'
        ], [
            'min_value' => 5000000,
            'benefit_value' => 5,
            'cycle' => 12
        ]);
        $vip->images()->delete();
        $vip->createImagesFromUrls(['https://cdn-icons-png.flaticon.com/512/6701/6701712.png']);
        $vvip = Rank::firstOrCreate([
            'name' => 'VVIP'
        ], [
            'min_value' => 15000000,
            'benefit_value' => 10,
            'cycle' => 12
        ]);
        $vvip->createImagesFromUrls(['https://cdn-icons-png.flaticon.com/512/6701/6701725.png']);
    }
}
