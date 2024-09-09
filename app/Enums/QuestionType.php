<?php
namespace App\Enums;

enum QuestionType:string {
    const explain = "تشریحی";
    const select = "چهار گزینه ای";
    const ALL=[
        self::explain,
        self::select,
    ];
}
