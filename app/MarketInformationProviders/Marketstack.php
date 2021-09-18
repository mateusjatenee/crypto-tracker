<?php

namespace App\MarketInformationProviders;

use App\Models\Asset;
use App\Market\FreshAsset;
use App\Contracts\MarketProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;

class Marketstack implements MarketProvider
{
    public function fetchAsset(Asset $asset): FreshAsset
    {
        $code = $asset->isBrazilian() ? $asset->code . '.BVMF' : $asset->code;

        $data = $this->getDataForTicker($code);

        return new FreshAsset(
            $asset->code,
            Arr::get(Arr::first($data['data']), 'close'),
            $this
        );
    }

    public function getDataForTicker(string $ticker)
    {
        return $this->client()
             ->get('eod', [
                 'access_key' => '1711f436d939f671dc9233fe52ac876d',
                 'symbols' => $ticker
             ])->json();
    }

    public function client(): PendingRequest
    {
        return Http::baseUrl('http://api.marketstack.com/v1');
    }
}
