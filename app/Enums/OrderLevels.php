<?php

namespace App\Enums;

enum OrderLevels: string
{
    const BEGINNER = 0;
    const INTERMEDIATE = 1;
    const ADVANCED = 2;
    const ALL = [
        self::BEGINNER,
        self::INTERMEDIATE,
        self::ADVANCED,
    ];
}
