<?php

namespace App;

use App\Models\Asset;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Collection;

class Position
{
    public function __construct(
        public Asset $asset,
        public Collection $transactions
    ) {
        //
    }

    public function averagePrice(): float
    {
        return $this->totalSpent() / $this->quantity();
    }

    public function quantity(): float
    {
        return $this->transactions->sum('quantity');
    }

    public function totalSpent(): float
    {
        return $this->transactions->sum(fn (Transaction $transaction) => $transaction->totalInvested());
    }

    public function totalPosition(): float
    {
        return $this->transactions->sum(fn (Transaction $transaction) => $transaction->total());
    }

    public function totalProfit(): float
    {
        return $this->totalPosition() - $this->totalSpent();
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
