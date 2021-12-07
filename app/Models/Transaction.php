<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Model;
use App\Collections\TransactionCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'quantity',
        'type',
        'avg_price_then',
        'profit',
        'date',
        'team_id',
        'asset_id'
    ];

    protected $casts = [
        'amount' => 'float',
        'quantity' => 'decimal:17',
        'profit' => 'decimal:2',
        'avg_price_then' => 'decimal:2',
        'type' => TransactionType::class,
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

    public function profit()
    {
        return $this->type === TransactionType::sell
            ? ($this->amount - $this->avg_price_then) * abs($this->quantity)
            : null;
    }

    public function formattedQuantity()
    {
        return number_format($this->quantity, 8);
    }

    public function formattedTotalInvested()
    {
        return number_format($this->totalInvested(), 2);
    }


    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new TransactionCollection($models);
    }
}
