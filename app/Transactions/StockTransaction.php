<?php

namespace App\Transactions;

use App\Models\Asset;
use App\Contracts\Transactionable;

class StockTransaction implements Transactionable
{
    public function __construct(
        public float $amount,
        public int $quantity,
        public Asset $asset
    ) {
        //
    }

    public function name(): string
    {
        return $this->asset->name;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function asset(): ?Asset
    {
        return $this->asset;
    }
}
