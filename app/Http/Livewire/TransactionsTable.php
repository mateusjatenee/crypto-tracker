<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class TransactionsTable extends Component
{
    public Account $account;

    protected $listeners = ['transactionCreated' => '$refresh'];

    public function render()
    {
        return view('livewire.transactions-table');
    }

    public function getTransactionsProperty()
    {
        return $this->account->transactions()->latest()->get();
    }
}
