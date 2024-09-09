<?php

namespace App\Enums;

enum CoinType: string
{
    const Silver = "silver";
    const Gold = "gold";

    const ALL = [
        self::Silver,
        self::Gold,

    ];
}
