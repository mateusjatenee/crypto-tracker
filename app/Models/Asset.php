<?php

namespace App\Models;

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
}
