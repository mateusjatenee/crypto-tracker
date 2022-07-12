<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;
use Mattiasgeniar\Percentage\Percentage;

class StatsGrid extends Component
{
    public Account $account;

    public function render()
    {
        return view('livewire.stats-grid');
    }

    public function getProfitInPercentageProperty(): float
    {
        if ($this->account->profit() == 0 || $this->account->totalInvested() == 0) {
            return 0;
        }
        number_format(
            Percentage::calculate($this->account->profit(), $this->account->totalInvested()),
            2
        );
    }
}
