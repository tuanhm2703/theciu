<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jd>
 */
class JdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
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
        ];
    }
}
