<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => Roles::Student]);
        Role::create(['name' => Roles::Teacher]);
        Role::create(['name' => Roles::Admin]);
        Role::create(['name' => Roles::SuperAdmin]);

    }
}
