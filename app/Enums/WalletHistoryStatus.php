<?php

namespace App\Enums;

enum WalletHistoryStatus: string
{
    const UNPAID = "پرداخت نشده";
    const PAID = "پرداخت شده";
    const WAIT = "در انتظار پرداخت";
    const CANCELE = "انصراف";
    const ALL = [
        self::UNPAID,
        self::PAID,
        self::WAIT,
        self::CANCELE
    ];
}
