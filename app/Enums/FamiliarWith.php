<?php

namespace App\Enums;

enum FamiliarWith: string
{
    const SearchGoogle = "جستجو گوگل";
    const Friends= "معرفی دوستان";
    const City = "تبلیغات شهری";
    const Internet = "فضای مجازی";
    const School = "مدرسه";
    const ALL = [
        self::SearchGoogle,
        self::Friends,
        self::City,
        self::Internet,
        self::School,
    ];
}
