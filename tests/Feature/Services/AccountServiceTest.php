<?php

use App\Models\Asset;
use App\Models\Account;
use App\Enums\AssetType;
use App\Services\AccountService;
use Database\Factories\AccountFactory;
use App\Transactions\CryptoTransaction;
use App\Transactions\StockTransaction;

it('gets assets based on crypto transactions', function () {
    $account = account();

    $ethereum = Asset::factory()->create([
        'type' => AssetType::CRYPTO,
        'code' => 'ETH',
        'current_price' => 3000
    ]);

    $bitcoin = Asset::factory()->create([
        'type' => AssetType::CRYPTO,
        'code' => 'BTC',
        'current_price' => 40000
    ]);

    $account->addTransaction(
        new CryptoTransaction(1000, 1, $ethereum)
    );

    $account->addTransaction(
        new CryptoTransaction(2500, 2, $ethereum)
    );

    $account->addTransaction(
        new CryptoTransaction(45000, 1, $bitcoin)
    );

    $positions = (new AccountService)->getPositions($account);

    expect($positions->first())
        ->averagePrice()->toBe(2000.0)
        ->quantity()->toBe(3.0)
        ->totalSpent()->toBe(6000.0)
        ->totalPosition()->toBe(9000.0)
        ->totalProfit()->toBe(3000.0)
        ->asset->is($ethereum)->toBeTrue();

    expect($positions->last())
        ->averagePrice()->toBe(45000.0)
        ->quantity()->toBe(1.0)
        ->totalSpent()->toBe(45000.0)
        ->totalPosition()->toBe(40000.0)
        ->totalProfit()->toBe(-5000.0)
        ->asset->is($bitcoin)->toBeTrue();
});

it('gets assets based on stocks transactions', function () {
    $account = account();

    $bankStock = Asset::factory()->create([
        'type' => AssetType::STOCK,
        'code' => 'BANK',
        'current_price' => 20
    ]);

    $airlineStock = Asset::factory()->create([
        'type' => AssetType::STOCK,
        'code' => 'AIRLINE',
        'current_price' => 30
    ]);

    $account->addTransaction(
        new StockTransaction(15, 100, $bankStock)
    );

    $account->addTransaction(
        new StockTransaction(18, 100, $bankStock)
    );

    $account->addTransaction(
        new StockTransaction(50, 100, $airlineStock)
    );

    $positions = (new AccountService)->getPositions($account);

    expect($positions->first())
        ->averagePrice()->toBe(16.50)
        ->quantity()->toBe(200.0)
        ->totalSpent()->toBe(3300.0)
        ->totalPosition()->toBe(4000.0)
        ->totalProfit()->toBe(700.0)
        ->asset->is($bankStock)->toBeTrue();

    expect($positions->last())
        ->averagePrice()->toBe(50.0)
        ->quantity()->toBe(100.0)
        ->totalSpent()->toBe(5000.0)
        ->totalPosition()->toBe(3000.0)
        ->totalProfit()->toBe(-2000.0)
        ->asset->is($airlineStock)->toBeTrue();
});

it('gets assets based on cash transactions');
