<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'course_id' => Course::inRandomOrder()->first()->id,
            'grade_id' => Grade::inRandomOrder()->first()->id,
        ];
    }
}
