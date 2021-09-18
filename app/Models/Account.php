<?php

namespace App\Models;

use App\Models\Transaction;
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

    public function addTransaction(string $title, float $amount): Transaction
    {
        return $this->transactions()->create([
            'title' => $title,
            'amount' => $amount,
            'team_id' => $this->team_id
        ]);
    }

    public function balance(): float
    {
        return $this->transactions->sum('amount');
    }
}
