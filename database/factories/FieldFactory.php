<?php

namespace Database\Factories;

use App\Models\Field;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class FieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $data= ['ریاضی','تجربی','فیزیک','آمار و احتمالات','کامپیوتر'];
        $random=rand(0,4);
        return [
            'name'=>$data[$random]
        ];
    }
}
