<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;

class CoinsPosition extends Component
{
    public Account $account;

    public function render()
    {
        return view('livewire.coins-position');
    }
}
