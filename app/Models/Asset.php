<?php

namespace App\Models;

use App\Enums\AssetType;
use App\Market\FreshAsset;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'current_price'
    ];

    public function prices(): MorphMany
    {
        return $this->morphMany(Price::class, 'priceable');
    }

    public function scopeCrypto(Builder $query): Builder
    {
        return $query->where('type', AssetType::CRYPTO);
    }

    public function currentPriceForQuantity(float $quantity): float
    {
        return $this->current_price * $quantity;
    }

    public function isStock(): bool
    {
        return $this->type === AssetType::STOCK;
    }

    public function isBrazilian(): bool
    {
        return $this->isStock();
    }

    public function updateFromFreshAsset(FreshAsset $freshAsset): void
    {
        $this->update([
            'current_price' => $freshAsset->price
        ]);

        $this->prices()->create([
            'price' => $freshAsset->price,
            'local_price' => $freshAsset->price
        ]);
    }

    public function iconUrl(): string
    {
        $code = Str::lower($this->code);

        return "https://cryptoicon-api.vercel.app/api/icon/{$code}";
    }
}
