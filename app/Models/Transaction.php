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
        'team_id',
        'asset_id'
    ];

    protected $casts = [
        'amount' => 'float',
        'quantity' => 'integer'
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
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
        if ($this->asset) {
            return $this->asset->current_price * $this->quantity;
        }

        return $this->amount * $this->quantity;
    }
}
