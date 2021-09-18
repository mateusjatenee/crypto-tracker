<?php

use App\Enums\AssetType;
use App\MarketInformationProviders\Marketstack;
use App\Models\Asset;

it('fetches information about a brazilian stock', function () {
    $asset = Asset::factory()->create(['code' =>  'BBDC3', 'type' => AssetType::STOCK]);

    $assetInformation = resolve(Marketstack::class)->fetchAsset($asset);
    dd($assetInformation);
    expect($assetInformation)
        ->ticker->toBe('BBDC4')
        ->price->toBeGreaterThan(10);
})->skip(fn () => env('RUN_EXTERNAL_TESTS') != true, 'Only runs on external tests.');
