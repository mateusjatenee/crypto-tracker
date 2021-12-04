<?php

use App\Enums\AssetType;
use App\Models\Asset;
use App\Transactions\CryptoTransaction;
use App\Transactions\StockTransaction;

it('adds a cash transaction to an account', function () {
    $account = account();
    $account->addCashTransaction('Some name', 2000);

    expect($account->transactions->first())
        ->name->toBe('Some name')
        ->amount->toBe(2000.00)
        ->quantity->toEqual(1)
        ->asset_id->toBeNull()
        ->user->is($account->user)->toBeTrue();
});

it('calculates the balance of an account', function () {
    $account = account();

    $account->addCashTransaction('Cash', 3000);
    $account->addCashTransaction('Cash', 2000);

    expect($account->balance())->toBe(5000.0);

    $account->addCashTransaction('Taxes', -10000);

    expect($account->fresh()->balance())->toBe(-5000.0);
});

it('it calculates the balance of an asset when it contains variable transactions (stocks)', function () {
    $account = account();

    $asset = Asset::factory()->create([
        'name' => 'Bradesco',
        'code' => 'BBDC4',
        'type' => AssetType::STOCK,
        'current_price' => 40
    ]);

    // Amount refers to the price paid per asset unit
    $account->addTransaction(
        new StockTransaction(
            amount: 15, // TODO: bad naming
            quantity: 100, // TODO: needs to be fractionable for crypto
            asset: $asset
        )
    );

    // Since the current price for the stock is 40 and they were bought for 15, the
    // profit per stock is 25.That also means the current balance is 40 * 100,
    // and the total invested is (15 * 100) = 1500 with a $2500 profit.

    expect($account)
        ->balance()->toBe(4000.00)
        ->totalInvested()->toBe(1500.00)
        ->profit()->toBe(2500.00);

    $account->addTransaction(
        new StockTransaction(
            amount: 32,
            quantity: 10,
            asset: $asset
        )
    );

    // Now that more 10 stocks @ 32 BRL have been added, the balance should increase by
    // 40 * 10 = 400 = 4400.
    // The total invested should increase by 320, becmoing 1820.

    $account->refresh();

    expect($account)
        ->balance()->toBe(4400.00)
        ->totalInvested()->toBe(1820.00)
        ->profit()->toBe(2580.00);
});

it('allows you to add a transaction based solely in the crypto values', function () {
    $account = account();

    $asset = Asset::factory()->create([
        'name' => 'Bitcoin',
        'code' => 'BTC',
        'type' => AssetType::CRYPTO,
        'current_price' => 48461.32
    ]);

    $amountBought = 5000; // USD 5000
    $amountOfBitcoin = $amountBought / $asset->current_price;

    $transaction = CryptoTransaction::fromCrypto(
        amountOfTokens: $amountOfBitcoin,
        asset: $asset
    );

    // Amount refers to the price paid per asset unit
    expect($transaction)
        ->amount()->toBe(48461.32)
        ->quantity()->toBe($amountOfBitcoin)
        ->total()->toBe(5000.0);

    $transaction = $account->addTransaction($transaction)->fresh();

    expect($transaction)
        ->totalInvested()->toBe(5000.0);
});
