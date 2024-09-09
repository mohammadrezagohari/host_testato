<?php

namespace Database\Factories;

use App\Models\SummaryFormula;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class SummaryFormulaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'unit_id' => Unit::inRandomOrder()->first()->id,
            'file_url' => $this->faker->imageUrl
        ];
    }
}
