<?php

namespace App\Contracts;

use App\Models\Asset;
use App\Enums\TransactionType;

interface Transactionable
{
    public function name(): string;

    public function amount(): float;

    public function quantity(): float;

    public function asset(): ?Asset;

    public function type(): TransactionType;

    public function profit(float $buyPrice): ?float;
}
