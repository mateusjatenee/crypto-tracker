<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use App\Position;
use Illuminate\Support\Collection;

class AccountService
{
    public function getPositions(Account $account): Collection
    {
        $transactions = $account->transactions()->with('asset')->get();

        $transactions = $transactions
            ->groupBy(fn ($transaction) => $transaction->asset->id)
            ->map(function (Collection $transactions) {
                $asset = $transactions->first()->asset;

                return Position::fromTransactions($transactions, $asset);
            });

        return $transactions;
    }
}
