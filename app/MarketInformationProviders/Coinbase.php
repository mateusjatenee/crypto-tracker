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

        $price = $this->client()->get("prices/{$asset->code}-USD/buy")->json();

        return new FreshAsset(
            $asset->code,
            Arr::get($price, 'data.amount', 0),
            $this
        );
    }

    public function fetchCurrencies(): array
    {
        return $this->client()->get('currencies')->json()['data'];
    }

    public function client(): PendingRequest
    {
        return Http::baseUrl('https://api.coinbase.com/v2');
    }
}
