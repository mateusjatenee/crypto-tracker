<?php

namespace App;

use App\Models\Asset;
use App\Models\Transaction;
use Illuminate\Support\Collection;
use App\Collections\TransactionCollection;

class Position
{
    public function __construct(
        public Asset $asset,
        public TransactionCollection $transactions
    ) {
        //
    }

    public function averagePrice(): float
    {
        return $this->totalSpent() / ($this->totalBought() ?: 1);
    }

    public function totalBought(): float
    {
        return $this->transactions->buy()->sum('quantity');
    }

    public function quantity(): float
    {
        return $this->transactions->sum('quantity');
    }

    public function totalSpent(): float
    {
        return $this->transactions->buy()->sum(fn (Transaction $transaction) => $transaction->totalInvested());
    }

    public function totalPosition(): float
    {
        return $this->transactions->sum(fn (Transaction $transaction) => $transaction->total());
    }

    public function realizedProfit(): float
    {
        return $this->transactions->sell()->sum(fn (Transaction $transaction) => $transaction->profit());
    }

    public function unrealizedProfit(): float
    {
        return $this->profitPerUnit() * $this->quantity();
    }

    public function profitPerUnit(): float
    {
        return $this->asset->current_price - $this->averagePrice();
    }

    public function totalProfit(): float
    {
        return $this->realizedProfit() + $this->unrealizedProfit();
    }

    /**
     * @param \Illuminate\Support\Collection<\App\Models\Transaction>
     * @param \App\Models\Asset
     *
     * @return static
     */
    public static function fromTransactions(Collection $transactions, Asset $asset): self
    {
        return new static($asset, $transactions);
    }
}
