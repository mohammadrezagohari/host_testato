<?php

namespace Database\Factories;

use App\Enums\ExamType;
use App\Models\Course;
use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $rndTwenty = rand(1,20);
        $rnd = rand(0,6);
        $rndUser = rand(1,4);
        $user = User::find($rndUser);
        return [
            'question_quantity' => $rndTwenty,
            'time_exam' => rand(1,20),
            'status' => ExamType::ALL[$rnd],
            'answer_quantity' => $rndTwenty,
            'user_id' => $user->id,
            'course_id' => Course::inRandomOrder()->first()->id,
            'level_id' => Level::inRandomOrder()->first()->id,
            'score' => $rndTwenty,
        ];
    }
}
