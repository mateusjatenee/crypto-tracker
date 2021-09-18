<?php

namespace App\Models;

use App\Enums\AssetType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'current_price'
    ];

    public function currentPriceForQuantity(int $quantity): float
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
}
