<?php

namespace App\Market;

use App\Contracts\MarketProvider;

class FreshAsset
{
    public function __construct(
        public string $name,
        public string $price,
        public MarketProvider $provider
    ) {
    }
}
