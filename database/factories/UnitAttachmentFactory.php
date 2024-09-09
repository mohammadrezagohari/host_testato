<?php

namespace Database\Factories;

use App\Models\Unit;
use App\Models\UnitAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class UnitAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'unit_id' => Unit::inRandomOrder()->first()->id,
            'image_url' => $this->faker->imageUrl(),
        ];
    }
}
