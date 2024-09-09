<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
//        $items = ['ریاضی', 'تجربی', 'فیزیک', 'آمار و احتمالات', 'کامپیوتر'];
//        foreach ($items as $item) {
//            Field::create(['name' => $item]);
//        }
        Field::factory(30)->create();


    }
}
