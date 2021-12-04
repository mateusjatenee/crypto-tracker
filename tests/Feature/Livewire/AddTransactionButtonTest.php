<?php

use App\Enums\AssetType;
use App\Http\Livewire\AddTransactionButton;
use Database\Factories\AssetFactory;
use Livewire\Livewire;

it('adds a transaction', function () {
    $this->withoutExceptionHandling();
    $account = account();

    $asset = AssetFactory::new()->create([
        'code' => 'ETH',
        'type' => AssetType::CRYPTO,
        'current_price' => 3000
    ]);

    Livewire::test(AddTransactionButton::class, ['account' => $account])
        ->set('state.asset_id', $asset->id)
        ->call('calculateAssetPrice')
        ->assertSet('state.asset_price', 3000.0)
        ->set('state.amount_in_tokens', 1.5)
        ->call('changedAmountOfTokens')
        ->assertSet('state.amount_in_dollars', 4500)
        ->call('addTransaction')
        ->assertEmitted('transactionCreated');

    $transaction = $account->transactions()->first();

    expect($transaction)
        ->amount->toBe((float) $asset->current_price)
        ->quantity->toEqual(1.5);
});
