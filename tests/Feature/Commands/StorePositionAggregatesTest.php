<?php

use App\Transactions\CryptoTransaction;
use Database\Factories\AssetFactory;
use Illuminate\Support\Facades\Artisan;

it('stores a positions aggregate', function () {
    $account = account();
    $asset = AssetFactory::new()->crypto()->create(['current_price' => 3000]);

    $transaction = $account->addTransaction(
        new CryptoTransaction(2500, 1.5, $asset)
    );

    Artisan::call('position-aggregates:build');

    $aggregate = $account->lastPositionAggregateForAsset($asset);

    expect($aggregate)
        ->quantity->toEqual(1.5)
        ->asset_unitary_price->toEqual(3000.0)
        ->profit->toEqual(750.0)
        ->asset->is($asset)->toBeTrue();
});

it('stores an account position', function () {
    $account = account();
    $btc = AssetFactory::new()->crypto()->create(['current_price' => 52000.43]);
    $eth = AssetFactory::new()->crypto()->create(['current_price' => 4096.61]);

    $firstTransaction = $account->addTransaction(
        new CryptoTransaction(50000, 1.5, $btc)
    );

    $secondTransaction = $account->addTransaction(
        new CryptoTransaction(4000, 1, $eth)
    );

    $balance = $account->balance();
    $profit = $account->profit();

    Artisan::call('position-aggregates:build');

    $aggregate = $account->lastPositionAggregate();

    expect($aggregate)
        ->quantity->toEqual(1)
        ->asset_unitary_price->toEqual(round($balance, 2))
        ->profit->toEqual(round($profit, 2))
        ->asset->toBeNull();
});
