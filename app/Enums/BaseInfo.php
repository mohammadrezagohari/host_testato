<?php

namespace App\Enums;

enum BaseInfo
{
    const categoryAll = "همه سوالات";
    const AboutPart = 'about_part';
    const CostCoinsPart = 'cost_coin_part';
    const CostPerQuestionGold = 'per_question_gold';
    const CostPerQuestionSilver = 'per_question_silver';
    const ALL = [
        self::CostPerQuestionGold,
        self::CostPerQuestionSilver
    ];

}
