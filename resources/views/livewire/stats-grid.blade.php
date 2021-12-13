<dl wire:poll
class="mt-5 grid grid-cols-1 rounded-lg bg-white overflow-hidden shadow divide-y divide-gray-200 md:grid-cols-3 md:divide-y-0 md:divide-x">
    <x-stat name="Starting Balance" :value="$account->totalInvested()" />
    <x-stat name="Current Balance" :value="$account->balance()" />
    <x-stat name="Profit" :value="$account->profit()" :increase="$this->profitInPercentage" />
</dl>