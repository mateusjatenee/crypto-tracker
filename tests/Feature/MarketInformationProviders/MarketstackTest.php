<?php

use App\Enums\AssetType;
use App\MarketInformationProviders\Marketstack;
use App\Models\Asset;

it('fetches information about a brazilian stock', function () {
    $asset = Asset::factory()->create(['code' =>  'BBDC3', 'type' => AssetType::STOCK]);

    $assetInformation = resolve(Marketstack::class)->fetchAsset($asset);

    expect($assetInformation)
        ->name->toBe('BBDC3')
        ->price->toBeGreaterThan(10);
})->skip(fn () => env('RUN_EXTERNAL_TESTS') != true, 'Only runs on external tests.');
