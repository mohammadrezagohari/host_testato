<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user= User::find(1);
        $user->Wallet()->create([
            'amount'=>0,
            'bonus'=>50000,
            'has_credit'=>true
        ]);
        $user= User::find(2);
        $user->Wallet()->create([
            'amount'=>0,
            'bonus'=>50000,
            'has_credit'=>true
        ]);
        $user= User::find(1);
        $user->Wallet()->create([
            'amount'=>0,
            'bonus'=>50000,
            'has_credit'=>true
        ]);
        $user= User::find(1);
        $user->Wallet()->create([
            'amount'=>0,
            'bonus'=>50000,
            'has_credit'=>true
        ]);
    }
}
