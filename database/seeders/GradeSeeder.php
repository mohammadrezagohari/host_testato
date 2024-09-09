<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $items = ['ریاضی', 'تجربی', 'فیزیک', 'آمار و احتمالات', 'کامپیوتر'];
//        foreach ($items as $key => $item) {
//            Grade::create(['name' => $item,'priority'=>$key]);
//        }
        Grade::factory(30)->create();

    }
}
