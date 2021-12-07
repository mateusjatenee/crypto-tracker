<?php

namespace App\Models;

use App\Position;
use Carbon\Carbon;
use App\Models\Asset;
use App\Enums\AccountType;
use App\Models\Transaction;
use App\Enums\TransactionType;
use App\Services\AccountService;
use App\Models\PositionAggregate;
use App\Contracts\Transactionable;
use Illuminate\Support\Collection;
use App\Enums\PositionAggregateType;
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

    public function positionAggregates(): HasMany
    {
        return $this->hasMany(PositionAggregate::class);
    }

    public function addTransaction(Transactionable $transactionable, Carbon $date = null): Transaction
    {
        $averagePrice = $this->positionForAsset($transactionable->asset)->averagePrice();

        return $this->transactions()->create([
            'name' => $transactionable->name(),
            'amount' => $transactionable->amount(),
            'quantity' => $transactionable->quantity(),
            'asset_id' => $transactionable->asset()?->id,
            'type' => $transactionable->type(),
            'avg_price_then' => $averagePrice,
            'profit' => $transactionable->profit(
                $this->positionForAsset($transactionable->asset)->averagePrice()
            ),
            'date' => $date ?? now()
        ]);
    }

    public function positions(): Collection
    {
        return (new AccountService())->getPositions($this)
            ->sortByDesc(fn (Position $position) => $position->totalPosition());
    }

    public function positionForAsset(Asset $asset): Position
    {
        return Position::fromTransactions(
            $this->transactions()->where('asset_id', $asset->id)->get(),
            $asset
        );
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

    public function lastPositionAggregateForAsset(Asset $asset): ?PositionAggregate
    {
        return $this->positionAggregates()->where('asset_id', $asset->id)->latest('id')->first();
    }

    public function lastPositionAggregate(): ?PositionAggregate
    {
        return $this->positionAggregates()->whereNull('asset_id')->latest('id')->first();
    }

    public function lastPositionAggregateOnDate(Carbon $date): ?PositionAggregate
    {
        return $this->positionAggregates()
            ->whereNull('asset_id')
            ->whereDate('created_at', $date)
            ->latest('id')
            ->first();
    }

    public function lastPositionAggregateForAssetOnDate(Asset $asset, Carbon $date): ?PositionAggregate
    {
        return $this->positionAggregates()
            ->where('asset_id', $asset->id)
            ->whereDate('created_at', $date)
            ->latest('id')
            ->first();
    }

    public function storeAggregateForAccount(): PositionAggregate
    {
        return $this->positionAggregates()->create([
            'quantity' => 1,
            'asset_unitary_price' => $this->balance(),
            'profit' => $this->profit(),
            'type' => PositionAggregateType::ACCOUNT
        ]);
    }

    public function storeAggregateForPosition(Position $position): PositionAggregate
    {
        return $this->positionAggregates()->create([
            'quantity' => $position->quantity(),
            'asset_unitary_price' => $position->asset->current_price,
            'profit' => $position->totalProfit(),
            'asset_id' => $position->asset->id,
            'type' => PositionAggregateType::ASSET
        ]);
    }
}
