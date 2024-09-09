<?php

namespace Database\Seeders;

use App\Models\Section;
use Database\Factories\SectionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::factory(20)->create();
    }
}
