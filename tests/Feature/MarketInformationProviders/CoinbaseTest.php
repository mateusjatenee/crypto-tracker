<?php

use App\Enums\AssetType;
use App\MarketInformationProviders\Coinbase;
use App\MarketInformationProviders\Marketstack;
use App\Models\Asset;

it('fetches BTC price', function () {
    $asset = Asset::factory()->create(['code' => 'BTC', 'type' => AssetType::CRYPTO]);

    $assetInformation = resolve(Coinbase::class)->fetchAsset($asset);

    expect($assetInformation)
        ->name->toBe('BTC')
        ->price->toBeGreaterThan(40000)
        ->provider->toBeInstanceOf(Coinbase::class);
})->skip(fn () => env('RUN_EXTERNAL_TESTS') != true, 'Only runs on external tests.');
