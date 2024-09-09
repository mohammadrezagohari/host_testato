<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\UnitAttachment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::factory(20)->create();
        UnitAttachment::factory(20)->create();
    }
}
