<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-container class="py-6">
        <div class="font-semibold tracking-tight text-2xl">
            Hello, {{ auth()->user()->name }}!
        </div>

        <div>
            <div>
                @livewire('stats-grid', ['account' => auth()->user()->defaultAccount()])
            </div>

        </div>
    </x-container>

    <x-container class="py-6">

        <div class="grid grid-cols-1 md:grid-cols-8 gap-6">
            <div class="sm:col-span-6 col-span-1">
                <div>
                    @livewire('positions-chart', ['account' => auth()->user()->defaultAccount()])
                </div>
                <div class="mt-4">
                    @livewire('transactions-table', ['account' => auth()->user()->defaultAccount()])
                </div>
            </div>
            <div class="sm:col-span-2 col-span-1 order-first sm:order-last">
                @livewire('coins-position', ['account' => auth()->user()->defaultAccount()])
            </div>
        </div>


    </x-container>
</x-app-layout>
