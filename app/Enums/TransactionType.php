<?php

namespace App\Enums;

enum TransactionType: string
{
    const Buy = "buy";
    const Pay = "pay";
    const ALL = [
        self::Buy,
        self::Pay,
    ];
}
