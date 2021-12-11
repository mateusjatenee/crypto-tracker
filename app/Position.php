<?php

namespace App;

use App\Models\Asset;
use App\Models\Transaction;
use App\Contracts\HasPositions;
use Illuminate\Support\Collection;
use Mattiasgeniar\Percentage\Percentage;
use App\Collections\TransactionCollection;

class Position
{
    public function __construct(
        public HasPositions $ledger,
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

    public function inPercentage(): float
    {
        return number_format(Percentage::calculate($this->totalPosition(), $this->ledger->totalPosition()), 2);
    }

    public function profitPercentage(): float
    {
        return number_format(
            Percentage::calculate($this->totalProfit(), $this->totalSpent()),
            2
        );
    }

    /**
     * @param \Illuminate\Support\Collection<\App\Models\Transaction>
     * @param \App\Models\Asset
     *
     * @return static
     */
    public static function fromTransactions(HasPositions $ledger, Collection $transactions, Asset $asset): self
    {
        return new static($ledger, $asset, $transactions);
    }
}
