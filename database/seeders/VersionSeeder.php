<?php

namespace Database\Seeders;

use App\Enums\VersionType;
use App\Models\Version;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Version::create([
            'version_base' => 1,
            'version_name' => "1.0.0",
            'type' => VersionType::DATA
        ]);
        Version::create([
            'version_base' => 1,
            'version_name' => "1.0.0",
            'type' => VersionType::APP
        ]);
    }
}
