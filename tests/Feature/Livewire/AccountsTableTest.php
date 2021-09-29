<?php

use App\Http\Livewire\AccountsTable;
use App\Models\Account;
use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Illuminate\Support\Arr;
use Livewire\Livewire;

it('creates an account', function () {
    $this->seed(CurrencySeeder::class);

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    Livewire::test(AccountsTable::class)
        ->set('data', [
            'name' => 'Test Account',
            'type' => Arr::random(Account::TYPES),
            'currency' => 'USD'
        ])
        ->call('createAccount')
        ->assertRedirect();

    $account = $user->currentTeam->accounts()->first();

    expect($account)
        ->name->toBe('Test Account')
        ->type->not->toBeNull()
        ->currency->code->toBe('USD');
});
