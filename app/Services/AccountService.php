<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use App\Position;
use Illuminate\Support\Collection;

class AccountService
{
    /**
     * Get the individual position for each asset.
     *
     * @param \App\Models\Account $account
     * @return \Illuminate\Support\Collection<\App\Position>
     */
    public function getPositions(Account $account): Collection
    {
        return $account->transactions()
                ->with('asset')
                ->get()
                ->groupBy(fn ($transaction) => $transaction->asset->id)
                ->map(function (Collection $transactions, $assetId) use ($account) {
                    return new Position($account, $transactions->first()->asset, $transactions);
                });
    }
}
