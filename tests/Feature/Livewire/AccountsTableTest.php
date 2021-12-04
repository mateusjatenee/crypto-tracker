<?php

use App\Http\Livewire\AccountsTable;
use App\Models\Account;
use App\Models\Currency;
use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Illuminate\Support\Arr;
use Livewire\Livewire;

it('creates an account', function () {
    $currency = Currency::factory()->create();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    Livewire::test(AccountsTable::class)
        ->set('data', [
            'name' => 'Test Account',
            'type' => Arr::random(Account::TYPES),
            'currency' => $currency->id
        ])
        ->call('createAccount')
        ->assertRedirect();

    $account = $user->accounts()->first();

    expect($account)
        ->name->toBe('Test Account')
        ->type->not->toBeNull()
        ->currency->code->toBe('USD');
});
