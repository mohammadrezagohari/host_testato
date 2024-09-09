<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->name(),
            'icon'=>$this->faker->imageUrl(),
            'background'=>$this->faker->hexColor(),
            'quantity_test'=>rand(1,8000),
            'quantity_description'=>0,
        ];
    }
}
