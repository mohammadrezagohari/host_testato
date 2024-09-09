<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BaseInfoSeeder::class,
            ContactSeeder::class,
//            SchoolSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
//            GradeSeeder::class,
//            MenuSeeder::class,
//            FieldSeeder::class,
//            CourseSeeder::class,
//            SliderSeeder::class,
//            StorySeeder::class,
//            UnitSeeder::class,
//            SectionSeeder::class,
//            LevelSeeder::class,
//            QuestionSeeder::class,
            CoinSeeder::class,
            VersionSeeder::class,
            SummerySeeder::class,
            ExamSeeder::class,
            PackageSeeder::class,
        ]);

    }
}
