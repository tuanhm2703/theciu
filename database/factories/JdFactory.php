<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jd>
 */
class JdFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
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
            'general_requirement' => [
                "level" => "Nhân viên",
                "experience" =>  "Dưới 1 năm kinh nghiệm",
                "salary" => [
                    "min" => "1000000",
                    "max" => "1000000"
                ],
                "work_from" => [
                    "from_day" => "Thứ 3",
                    "to_day" => "Thứ 7",
                    "from_hour" => "09:00",
                    "to_hour" => "20:00"
                ],
                "gender" => "Nữ",
                "required_skills" => "Photoshop"
            ],
            "position" => fake()->jobTitle(),
            'quantity' => fake()->numberBetween(1, 10)
        ];
    }
}
