<?php

namespace App\Transactions;

use App\Models\Asset;
use App\Contracts\Transactionable;
use App\Enums\TransactionType;
use App\Models\Transaction;

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

    public function type(): TransactionType
    {
        return $this->quantity() > 0
            ? TransactionType::buy
            : TransactionType::sell;
    }

    /**
     * Calculates the profit on a sell operation based on the price
     * for which an asset was bought (e.g: average price).
     *
     * @param  float $buyPrice
     * @return float|null
     */
    public function profit(float $buyPrice): ?float
    {
        if ($this->type() === TransactionType::buy) {
            return null;
        }

        return -1 * (($this->amount() - $buyPrice) * $this->quantity());
    }

    public static function fromCrypto(float $amountOfTokens, Asset $asset): self
    {
        return new static($asset->current_price, $amountOfTokens, $asset);
    }
}
