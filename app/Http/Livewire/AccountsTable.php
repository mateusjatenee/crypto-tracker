<?php

namespace App\Http\Livewire;

use App\Enums\AccountType;
use App\Models\Account;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AccountsTable extends Component
{
    public $newAccountModalOpen = false;

    public array $data = [
        'name' => '',
        'type' => AccountType::STOCKS,
        'currency' => 1
    ];

    public Collection $accounts;

    public function mount()
    {
        $this->accounts = auth()->user()->accounts;
    }

    public function render()
    {
        return view('livewire.accounts-table');
    }

    public function createAccount()
    {
        Validator::make($this->data, [
            'name' => ['required', 'string'],
            'type' => ['required', Rule::in(Account::TYPES)]
        ]);

        auth()->user()->accounts()->create([
            'name' => $this->data['name'],
            'type' => $this->data['type'],
            'currency_id' => Currency::find($this->data['currency'])->id
        ]);

        return $this->redirect('dashboard');
    }

    public function openNewAccountModal(): void
    {
        $this->newAccountModalOpen = true;
    }

    public function closeNewAccountModal(): void
    {
        $this->newAccountModalOpen = false;
    }

    public function getAvailableAccountTypesProperty(): array
    {
        return Account::TYPES;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\Currency>
     */
    public function getAvailableCurrenciesProperty(): Collection
    {
        return Currency::all();
    }
}
