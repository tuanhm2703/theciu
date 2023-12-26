<?php

namespace Database\Seeders;

use App\Models\Jd;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JdSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Jd::factory(20)->create();
    }
}
