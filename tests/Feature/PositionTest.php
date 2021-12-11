<?php

use App\Models\Asset;
use App\Enums\AssetType;
use App\Transactions\CryptoTransaction;
use Database\Factories\AssetFactory;

beforeEach(function () {
    $this->ethereum = AssetFactory::new()->crypto()->create(['code' => 'ETH', 'current_price' => 100]);
    $this->bitcoin = AssetFactory::new()->crypto()->create(['code' => 'BTC', 'current_price' => 100]);
});

it('calculates the percentage in the portfolio', function () {
    $account = account();

    // BUY 100 eth @ $100
    $account->addTransaction(
        new CryptoTransaction(100, 100, test()->ethereum)
    );

    $account->addTransaction(
        new CryptoTransaction(100, 200, test()->bitcoin)
    );

    $account->refresh();

    expect($account->positionForAsset(test()->ethereum))
        ->inPercentage()->toBe(33.33);

    expect($account->positionForAsset(test()->bitcoin))
        ->inPercentage()->toBe(66.67);
});

it('calculates the profit per position', function () {
    $account = account();

    // BUY 100 eth @ $100
    $account->addTransaction(
        new CryptoTransaction(50, 100, test()->ethereum)
    );

    $account->addTransaction(
        new CryptoTransaction(200, 200, test()->bitcoin)
    );

    expect($account->positionForAsset(test()->ethereum))
        ->profitPercentage()->toBe(100.00)
        ->and($account->positionForAsset(test()->bitcoin))
        ->profitPercentage()->toBe(-50.00);
});
