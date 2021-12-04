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
        <div class="text-gray-700 mt-2">
            These are your stats for <span class="px-2 py-1 rounded-md border-2 border-gray-200 text-lg">this
                month</span>
        </div>

        <div>
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div>
                <dl
                    class="mt-5 grid grid-cols-1 rounded-lg bg-white overflow-hidden shadow divide-y divide-gray-200 md:grid-cols-3 md:divide-y-0 md:divide-x">
                    <x-stat name="Total Assets" :value="5997.53" :increase="0.053" />
                    <x-stat name="Revenue" :value="-573.19" :increase="-0.095" />
                    <x-stat name="Net Gross Income" :value="1098.56" :increase="0.055" />
                </dl>
            </div>

        </div>
    </x-container>

    <x-container class="py-6">

        <div class="grid md:grid-cols-8 gap-4">
            <div class="col-span-6">
                @livewire('transactions-table', ['account' => auth()->user()->defaultAccount()])
            </div>
        </div>

        {{-- <div class="grid md:grid-cols-8 gap-4">
            <div class="bg-white sm:px-4 py-5 border-b border-gray-200 sm:px-6 col-span-8">
                <div class="col-span-5">
                    <h3 class="text-xl leading-6 font-semibold tracking-tight text-gray-900 inline-flex">
                        <x-heroicon-o-chart-bar class="w-5 h-5 mr-1 text-green-600" /> Asset Development
                    </h3>
                    <canvas class="p-10 " id="chartLine"></canvas>
                </div>
            </div>

        </div> --}}



    </x-container>

    <script>

        const labels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
        ];
        const data = {
            labels: labels,
            datasets: [{
                label: 'My First dataset',
                backgroundColor: 'hsl(252, 82.9%, 67.8%)',
                borderColor: 'hsl(252, 82.9%, 67.8%)',
                data: [0, 10, 5, 2, 20, 30, 45],
            }]
        };
    
        const configLineChart = {
            type: 'line',
            data,
            options: {}
        };
    
        var chartLine = new Chart(
            document.getElementById('chartLine'),
            configLineChart
        );
    </script>
</x-app-layout>
