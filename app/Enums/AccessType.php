<?php

namespace App\Enums;

enum AccessType: string
{
    const Undefined = "تعیین نشده";
    const Family = "خانواده";
    const Teacher = "مدرس";
    const Student = "دانش آموز";
    const ALL = [
        self::Undefined,
        self::Student,
        self::Family,
        self::Teacher,
    ];
}
