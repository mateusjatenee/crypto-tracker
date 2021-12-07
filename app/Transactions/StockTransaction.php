<?php

namespace App\Transactions;

use App\Models\Asset;
use App\Enums\TransactionType;
use App\Contracts\Transactionable;
use App\Models\Transaction;

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

    public function quantity(): float
    {
        return $this->quantity;
    }

    public function asset(): ?Asset
    {
        return $this->asset;
    }

    public function type(): TransactionType
    {
        return $this->quantity() > 0
            ? TransactionType::buy
            : TransactionType::sell;
    }

    public function profit(float $buyPrice = null): ?float
    {
        return null;
    }
}
