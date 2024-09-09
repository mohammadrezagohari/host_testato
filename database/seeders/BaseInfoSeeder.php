<?php

namespace Database\Seeders;

use App\Models\BaseInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BaseInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        BaseInfo::create([  // ساخت قیمت برای سکه طلایی ای بخش قیمت های سکه درون جدول پایه
            'key' => \App\Enums\BaseInfo::CostPerQuestionGold,
            'value' => '2',
            'section' => \App\Enums\BaseInfo::CostCoinsPart,
        ]);

        BaseInfo::create([  // ساخت قیمت برای سکه نقره ای بخش قیمت های سکه درون جدول پایه
            'key' => \App\Enums\BaseInfo::CostPerQuestionSilver,
            'value' => '4',
            'section' => \App\Enums\BaseInfo::CostCoinsPart,
        ]);

        $description_wallet = BaseInfo::create([
            'key' => 'description_wallet',
            'value' => 'لوریسم این متن توضیحاتی برای بخش توضیحات wallet  می باشد.',
            'section' => 'wallet',
        ]);

        $title_about = BaseInfo::create([
            'key' => "title",
            'value' => 'لوریسم این متن آزمایشی است...',
            'section' => \App\Enums\BaseInfo::AboutPart,
        ]);

        $context_about = BaseInfo::create([
            'key' => "context",
            'value' => ' و لوریسم این متن آزمایشی است و لوریسم این متن آزمایشی است و لوریسم این متن آزمایشی است لوریسم این متن آزمایشی است و لوریسم این متن آزمایشی است',
            'section' => \App\Enums\BaseInfo::AboutPart,
        ]);

    }
}
