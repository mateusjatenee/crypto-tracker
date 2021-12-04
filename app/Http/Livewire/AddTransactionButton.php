<?php

namespace App\Http\Livewire;

use App\Models\Asset;
use App\Models\Account;
use App\Transactions\CryptoTransaction;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AddTransactionButton extends Component
{
    public Account $account;

    public bool $newTransactionModalOpen = false;

    public $state = [
        'asset_id' => null,
        'asset_price' => 0,
        'amount_in_tokens' => 0,
        'amount_in_dollars' => 0
    ];

    public function render()
    {
        return view('livewire.add-transaction-button');
    }

    public function addTransaction()
    {
        $data = Validator::make($this->state, [
            'asset_id' => ['required', Rule::exists('assets', 'id')],
            'asset_price' => ['required', 'numeric', 'gt:0'],
            'amount_in_tokens' => ['required', 'numeric', 'gt:0'],
            'amount_in_dollars' => ['required', 'numeric', 'gt:0']
        ])->validate();

        $this->account->addTransaction(
            CryptoTransaction::fromCrypto(
                $data['amount_in_tokens'],
                $this->getSelectedAssetProperty()
            )
        );

        $this->closeNewTransactionModal();

        $this->emit('transactionCreated');
    }

    public function closeNewTransactionModal(): void
    {
        $this->newTransactionModalOpen = false;
    }

    public function getAvailableAssetsProperty()
    {
        return Asset::all();
    }

    public function getSelectedAssetProperty(): ?Asset
    {
        return Asset::find($this->state['asset_id']);
    }

    public function changedAsset()
    {
        $this->calculateAssetPrice();
    }

    public function changedCurrentAssetPrice()
    {
        $this->state['amount_in_dollars'] = 0;
        $this->state['amount_in_tokens'] = 0;
    }

    public function changedAmountOfTokens()
    {
        $this->state['amount_in_dollars'] = $this->getSelectedAssetProperty()->current_price * $this->state['amount_in_tokens'];
    }

    public function changedAmountOfDollars()
    {
        $this->state['amount_in_tokens'] = $this->state['amount_in_dollars'] / $this->getSelectedAssetProperty()->current_price;
    }

    public function calculateAssetPrice()
    {
        $this->state['asset_price'] = $this->getSelectedAssetProperty()->current_price;
    }
}
