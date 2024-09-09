<?php

namespace Database\Seeders;

use App\Http\Controllers\SummaryFormulaController;
use App\Models\SummaryFormula;
use App\Models\UnitExercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SummerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //SummaryFormula::factory(50)->create();
		UnitExercise::factory(50)->create();
    }
}
