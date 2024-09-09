<?php

namespace App\Enums;

enum QuestionFileType: string
{
    const Video = 'video';
    const Image = 'image';
    const ALL = [
        self::Video,
        self::Image,
    ];
}
