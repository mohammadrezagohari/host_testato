<?php

namespace App\Enums;

enum AttachmentType: string
{
    const VIDEO = "video";
    const IMAGE = "image";
    const ALL = [
        self::VIDEO,
        self::IMAGE,
    ];
}
