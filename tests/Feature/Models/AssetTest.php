<?php

use App\Models\Asset;

it('calculates the balance of an asset', function () {
    $asset = Asset::factory()->create();

    $asset->addTransaction('Cash', 3000);
    $asset->addTransaction('Cash', 2000);

    expect($asset->balance())->toBe(5000.0);

    $asset->addTransaction('Taxes', -10000);

    expect($asset->fresh()->balance())->toBe(-5000.0);
});

it('it calculates the balance of an asset when it contains variable transactions (stocks)', function () {
    $asset = Asset::factory()->create();
})->skip();
