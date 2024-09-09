<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rnd= rand(0,1);
        $admin = User::create([
            'sex' => 1,
            'avatar' => $rnd,
            'email_verified_at' => now(),
            'is_enable' => $rnd,
            'mobile' => '09114160048',
            'name' => 'هدیه صادقی',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $admin->assignRole(Role::findByName(Roles::Admin));

        $superAdmin = User::create([
            'sex' => 1,
            'avatar' => $rnd,
            'email_verified_at' => now(),
            'is_enable' => $rnd,
            'mobile' => '09117184875',
            'name' => 'محمدرضا گوهری',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $superAdmin->assignRole(Role::findByName(Roles::SuperAdmin));

        $teacher = User::create([
            'sex' => 1,
            'avatar' => $rnd,
            'email_verified_at' => now(),
            'is_enable' => $rnd,
            'mobile' => '09114119225',
            'name' => 'علی اسدپور',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password

        ]);
        $teacher->assignRole(Role::findByName(Roles::Teacher));

        $student = User::create([
            'mobile' => '09371801145',
            'name' => 'محمدرضا گوهری',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $student->assignRole(Role::findByName(Roles::Student));
    }
}
