<?php

namespace Database\Seeders;

use App\Models\PackageCoin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PackageCoin::create([
            'title'=>'500 تایی',
            'quantity'=>500,
        ]);
        PackageCoin::create([
            'title'=>'200 تایی',
            'quantity'=>200,
        ]);
        PackageCoin::create([
            'title'=>'100 تایی',
            'quantity'=>100,
        ]);
    }
}
