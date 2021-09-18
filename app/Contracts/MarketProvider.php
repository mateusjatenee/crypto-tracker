<?php

namespace App\Contracts;

use App\Market\FreshAsset;
use App\Models\Asset;

interface MarketProvider
{
    public function fetchAsset(Asset $asset): FreshAsset;
}
