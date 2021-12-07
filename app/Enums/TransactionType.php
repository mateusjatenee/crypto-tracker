<?php

namespace App\Enums;

enum TransactionType: string
{
    case buy = 'buy';
    case sell = 'sell';
}
