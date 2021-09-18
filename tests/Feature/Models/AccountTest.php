<?php

it('adds a cash transaction to an account', function () {
    $account = account();
    $account->addCashTransaction('Some name', 2000);

    expect($account->transactions->first())
        ->name->toBe('Some name')
        ->amount->toBe(2000.00)
        ->quantity->toBe(1)
        ->asset_id->toBeNull()
        ->team->is($account->team)->toBeTrue();
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
});
