<?php

namespace App\Enums;

enum AlertTypeAccess: string
{
    const Private = "private";
    const Public = "public";
    const ALL = [
        self::Private,
        self::Public,
    ];
}
