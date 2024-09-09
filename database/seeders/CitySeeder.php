<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Increase max queries
//        $this->command->getOutput()->progressStart(1000000);
        $json_file = File::get(database_path('data/cities.json'));
        $cities = json_decode($json_file);
        foreach ($cities as $city) {
            City::create([
                'province_id' => $city->province_id,
                'name' => $city->name,
                'slug' => $city->slug
            ]);
        }
    }
}
