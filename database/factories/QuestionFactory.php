<?php

namespace Database\Factories;

use App\Enums\QuestionType;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Level;
use App\Models\Section;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class QuestionFactory extends Factory
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
            'questions_type' => QuestionType::select,
            'level_id' => Level::inRandomOrder()->first()->id,
            'course_id' => Course::inRandomOrder()->first()->id,
            'unit_id' => Unit::inRandomOrder()->first()->id,
            'section_id' => Section::inRandomOrder()->first()->id,
            'grade_id' => Grade::inRandomOrder()->first()->id,
            'teacher_id' => 1
        ];
    }
}
