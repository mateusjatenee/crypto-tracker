<?php

use App\Models\Asset;
use App\Models\Account;

it('calculates the balance of an account', function () {
    $account = Account::factory()->create();

    $account->addTransaction('Cash', 3000);
    $account->addTransaction('Cash', 2000);

    expect($account->balance())->toBe(5000.0);

    $account->addTransaction('Taxes', -10000);

    expect($account->fresh()->balance())->toBe(-5000.0);
});

it('it calculates the balance of an asset when it contains variable transactions (stocks)', function () {
    $account = Account::factory()->create();
})->skip();
