<div class="bg-white py-2 rounded-md shadow-sm">
    <div class="px-4 w-full inline-flex justify-between py-1">
        <h3 class="text-xl leading-6 font-semibold tracking-tight text-gray-900 inline-flex">
             Profit over time
        </h3>
    </div>
    <div style="height: 16rem;">
        <livewire:livewire-line-chart
        :line-chart-model="$chart" />
    </div>
</div>