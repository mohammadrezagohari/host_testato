<?php

namespace Database\Factories;

use App\Enums\MimeImages;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class SliderFactory extends Factory
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
            'priority_order' => rand(1, 8),
            'file_url' => $this->faker->imageUrl(),
            'mime_type' => MimeImages::ALL[rand(0,3)],
            'file_size' => rand(100, 4096)
        ];
    }
}
