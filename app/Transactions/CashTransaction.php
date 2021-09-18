<?php

namespace App\Transactions;

use App\Models\Asset;
use App\Contracts\Transactionable;

class CashTransaction implements Transactionable
{
    public function __construct(
        public string $name,
        public float $amount
    ) {
        //
    }

    public function name(): string
    {
        return $this->name;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function quantity(): int
    {
        return 1;
    }

    public function asset(): ?Asset
    {
        return null;
    }
}
