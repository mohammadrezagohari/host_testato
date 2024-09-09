<?php

namespace App\Enums;

enum ExamType: string
{
    const created = 'ساخته شده';
    const started = 'شروع شده';
    const doing = 'در حال انجام';
    const done = 'انجام شده';
    const timeout = 'زمان آزمون به اتمام رسیده';
    const noResponse = 'بدون پاسخ';
    const stopped = 'متوقف شده';
    const finishedCollection = [
        self::timeout,
        self::done
    ];
    const ALL = [
        self::created,
        self::started,
        self::doing,
        self::done,
        self::timeout,
        self::noResponse,
        self::stopped,
    ];
}
