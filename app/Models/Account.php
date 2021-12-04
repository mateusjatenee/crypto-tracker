<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\AccountType;
use App\Models\Transaction;
use App\Contracts\Transactionable;
use App\Services\AccountService;
use Illuminate\Support\Collection;
use App\Transactions\CashTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'currency_id',
        'team_id'
    ];

    public const TYPES = [
        AccountType::CRYPTO => 'Crypto',
        AccountType::STOCKS => 'Stocks',
        AccountType::CASH => 'Bank'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function addTransaction(Transactionable $transactionable, Carbon $date = null): Transaction
    {
        return $this->transactions()->create([
            'name' => $transactionable->name(),
            'amount' => $transactionable->amount(),
            'quantity' => $transactionable->quantity(),
            'asset_id' => $transactionable->asset()?->id,
            'date' => $date ?? now()
        ]);
    }

    public function positions(): Collection
    {
        return resolve(AccountService::class)->getPositions($this);
    }

    public function addCashTransaction(string $name, float $amount): Transaction
    {
        return $this->addTransaction(
            new CashTransaction($name, $amount)
        );
    }

    public function balance(): float
    {
        return $this->transactions->sum(fn (Transaction $transaction) => $transaction->total());
    }

    public function totalInvested(): float
    {
        return $this->transactions->sum(fn (Transaction $transaction) => $transaction->totalInvested());
    }

    public function profit(): float
    {
        return $this->balance() - $this->totalInvested();
    }
}
