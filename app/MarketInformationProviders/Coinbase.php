<?php

namespace App\MarketInformationProviders;

use App\Models\Asset;
use App\Market\FreshAsset;
use App\Contracts\MarketProvider;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;

class Coinbase implements MarketProvider
{
    public function fetchAsset(Asset $asset): FreshAsset
    {
        if ($asset->isStock()) {
            throw new Exception();
        }

        $price = $this->client()->get("{$asset->code}-USD/buy")->json();

        return new FreshAsset(
            $asset->code,
            Arr::get($price, 'data.amount'),
            $this
        );
    }

    public function client(): PendingRequest
    {
        return Http::baseUrl('https://api.coinbase.com/v2/prices');
    }
}
