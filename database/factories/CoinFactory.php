<?php

namespace Database\Factories;

use App\Models\Coin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CoinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $coin = ['-', 'gold', 'silver'];
        $rnd = rand(1, 2);
        return [
            'coin_name' => $coin[$rnd],
            'rank' => $rnd,
            'coin_amount' => $rnd
        ];
    }
}
