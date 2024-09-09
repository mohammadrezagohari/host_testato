<?php

namespace Database\Factories;

use App\Enums\VideoUrlEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Story>
 */
class StoryFactory extends Factory
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
            'link' => $this->faker->url(),
            'file_url' => VideoUrlEnum::ALL[rand(0, 3)],
            'mime_type' => "video/mp4",
            'file_size' => rand(100, 4096)
        ];
    }
}
