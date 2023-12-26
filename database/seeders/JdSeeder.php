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
        Jd::factory(20)->create([
            'name' => fake()->jobTitle(),
            'group' => fake()->country(),
            'job_type' => rand(1, 2) == 1 ? 'Parttime' : 'Fullname',
            'from_date' => now(),
            'to_date' => now()->addMonth(1),
            'status' => 1,
            'short_description' => fake()->paragraphs(1, true),
            'description' => fake()->paragraphs(2, true),
            'requirement' => fake()->paragraphs(5, true),
            'benefit' => fake()->paragraphs(5, true),
        ]);
    }
}
