<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\Currency;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AccountsTable extends Component
{
    public $newAccountModalOpen = false;

    public array $data = [
        'name' => '',
        'type' => '',
        'currency' => ''
    ];

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

        team()->accounts()->create([
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
}
