<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coin::create([
            'coin_name' => 'silver',
            'rank' => 2,
            'coin_amount' => 1
        ]);
        Coin::create([
            'coin_name' => 'gold',
            'rank' => 1,
            'coin_amount' => 2
        ]);
    }
}
