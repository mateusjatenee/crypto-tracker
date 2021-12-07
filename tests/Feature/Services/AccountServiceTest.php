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

    $positions = (new AccountService())->getPositions($account);

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

it('builds a crypto position w/ sell transactions', function () {
    $account = account();

    $ethereum = Asset::factory()->create([
        'type' => AssetType::CRYPTO,
        'code' => 'ETH',
        'current_price' => 500
    ]);

    // BUY 100 eth @ $100
    $account->addTransaction(
        new CryptoTransaction(100, 100, $ethereum)
    );

    // SELL 50 eth @ $200
    $account->addTransaction(
        new CryptoTransaction(200, -50, $ethereum)
    );

    // BALANCE 50 ETH @ $100(avg price = only BUY transactions)
    // REALIZED GAINS = (200 (sell price) - 100 (buy price)) * 50 = 5000

    // UNREALIZED GAINS = (500 - 100[avg_price]) * 50 = 20000
    // TOTAL GAINS = RG + UG = 25000

    // app calculation
    // avg_price = (positive ops total) / (positive ops qty)
    // avg_price = (100 * 100) / (100) = $100

    // current position = (BUY qty - SELL qty) = 100 - 50
    // current position = 50 eth
    // current profit = (current price - pm) * current position
    // current profit = (500 - 100) * 50 = 2000

    // past profit = …sellTransactions.sum(t => t.profit) = 5000

    expect($account->positions()->first())
        ->quantity()->toEqual(50.0) // BALANCE 50 ETH @ $100(avg price: only include positive transactions)
        ->averagePrice()->toEqual(100.0)
        ->totalPosition()->toEqual(25000.0) // 50 * $500 (current price) = 25000
        ->unrealizedProfit()->toEqual(20000.0)
        ->realizedProfit()->toEqual(5000.0)
        ->totalProfit()->toEqual(25000.0) // (50 * $500 (current price) - $100 (avg price)) = 20000 + $5000 (realized gains)
        ->totalSpent()->toEqual(10000.0); // 100 eth @ $100
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

    $positions = (new AccountService())->getPositions($account);

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
