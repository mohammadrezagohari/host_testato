<?php

namespace App\Enums;

enum VersionType: string
{
    const DATA = "data";
    const APP = "app";
    const ALL = [
        self::DATA,
        self::APP,
    ];
}
