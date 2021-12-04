<?php

namespace App\Transactions;

use App\Models\Asset;
use App\Contracts\Transactionable;

class CryptoTransaction implements Transactionable
{
    public function __construct(
        public float $amount,
        public float $quantity,
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

    public function total(): float
    {
        return $this->amount * $this->quantity;
    }

    public function asset(): ?Asset
    {
        return $this->asset;
    }

    public static function fromCrypto(float $amountOfTokens, Asset $asset): self
    {
        return new static($asset->current_price, $amountOfTokens, $asset);
    }
}
