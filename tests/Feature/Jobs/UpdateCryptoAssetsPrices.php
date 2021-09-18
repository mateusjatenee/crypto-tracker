<?php

use App\Jobs\UpdateCryptoAssetsPrices;
use App\Models\Asset;

it('updates crypto prices', function () {
    $solana = Asset::factory()->crypto()->create([
        'name' => 'Solana',
        'code' => 'SOL'
    ]);

    $btc = Asset::factory()->crypto()->create([
        'name' => 'Bitcoin',
        'code' => 'BTC'
    ]);

    expect($solana)->current_price->toBeNull();
    expect($btc)->current_price->toBeNull();

    (new UpdateCryptoAssetsPrices)->handle();

    $solana->refresh();
    $btc->refresh();

    expect($solana->current_price)->not->toBeNull()
        ->and($btc->current_price)->not->toBeNull();

    expect($solana->prices->count())->toBe(1)
        ->and($solana->prices->count())->toBe(1);
});
