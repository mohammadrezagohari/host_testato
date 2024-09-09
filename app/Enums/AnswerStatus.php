<?php

namespace App\Enums;

use phpDocumentor\Reflection\Types\Boolean;

enum AnswerStatus: int
{
    const answerFalse = 0;
    const answerTrue = 1;
    const noAnswer = 2;
    const unRead = 3;
    const ALL = [
        self::answerFalse,
        self::answerTrue,
        self::noAnswer,
        self::unRead,
    ];
}
