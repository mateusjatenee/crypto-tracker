<?php

namespace App\Models;

use App\Contracts\Transactionable;
use App\Models\Transaction;
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
        'team_id'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function addTransaction(Transactionable $transactionable): Transaction
    {
        return $this->transactions()->create([
            'name' => $transactionable->name(),
            'amount' => $transactionable->amount(),
            'quantity' => $transactionable->quantity(),
            'asset_id' => $transactionable->asset(),
            'team_id' => $this->team_id
        ]);
    }

    public function addCashTransaction(string $name, float $amount): Transaction
    {
        return $this->addTransaction(
            new CashTransaction($name, $amount)
        );
    }

    public function balance(): float
    {
        return $this->transactions->sum('amount');
    }
}
