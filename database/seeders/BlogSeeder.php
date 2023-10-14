<?php

namespace Database\Seeders;

use App\Enums\BlogType;
use App\Enums\StatusType;
use App\Models\Blog;
use Faker\Provider\Lorem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        Blog::factory(10)->create([
            'title' => fake()->sentence(),
        'description' => implode(' ', Lorem::words(10)),
        'content' => implode('\n', Lorem::paragraphs(4)),
        'publish_date' => fake()->date(),
        'status' => StatusType::ACTIVE,
        'type' => BlogType::CAREER
        ]);
    }
}
