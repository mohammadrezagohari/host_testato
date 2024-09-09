<?php

namespace App\Enums;

enum VideoUrlEnum: string
{
    const file1 = "https://download.samplelib.com/mp4/sample-5s.mp4";
    const file2 = "https://download.samplelib.com/mp4/sample-10s.mp4";
    const file3 = "https://download.samplelib.com/mp4/sample-15s.mp4";
    const file4 = "https://download.samplelib.com/mp4/sample-20s.mp4";
    const ALL = [
        self::file1,
        self::file2,
        self::file3,
        self::file4,
    ];
}
