<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PositionAggregate extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'asset_unitary_price',
        'profit',
        'type',
        'account_id',
        'asset_id'
    ];

    protected $casts = [
        'quantity' => 'decimal:17',
        'asset_unitary_price' => 'decimal:2',
        'profit' => 'decimal:2'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function total(): float
    {
        return $this->quantity * $this->asset_unitary_price;
    }
}
