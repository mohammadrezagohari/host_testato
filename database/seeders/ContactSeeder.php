<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::create([
            'mobile'    =>"09371801145",
            'email'     =>"info@testato.ir",
            'address'   =>"مازندران - قائمشهر",
            'instagram' =>"https://instagram.com/testato.ir/",
        ]);
    }
}
