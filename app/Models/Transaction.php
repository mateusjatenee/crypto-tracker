<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'quantity',
        'date',
        'team_id',
        'asset_id'
    ];

    protected $casts = [
        'amount' => 'float',
        'quantity' => 'integer',
        'date' => 'datetime'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->account->user();
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function totalInvested(): float
    {
        return $this->amount * $this->quantity;
    }

    public function total(): float
    {
        return $this->asset
            ? $this->asset->currentPriceForQuantity($this->quantity)
            : ($this->amount * $this->quantity);
    }
}
