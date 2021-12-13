<div class="bg-white py-2 rounded-md shadow-sm">
    <div class="px-4 w-full inline-flex justify-between py-1">
        <h3 class="text-xl leading-6 font-semibold tracking-tight text-gray-900 inline-flex">
             {{ $this->title }}
        </h3>
        <fieldset>
            <legend class="sr-only">
              Choose a memory option
            </legend>
            <div class="flex space-x-4">
              @foreach ($types as $availableType)
                <label wire:click="$set('type', '{{ $availableType }}')" class="@if ($availableType === $type) bg-blue-600 border-transparent text-white hover:bg-blue-700 @else bg-white border-gray-200 text-gray-900 hover:bg-gray-50 @endif border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                    <input type="radio" name="memory-option" value="4 GB" class="sr-only" aria-labelledby="memory-option-0-label">
                    <p id="memory-option-0-label">
                    {{ $availableType }}
                    </p>
                </label>
              @endforeach

            </div>
          </fieldset>
    </div>
    <div style="height: 20rem;">
        <livewire:livewire-line-chart
        key="{{ $chart->reactiveKey() }}"
        :line-chart-model="$chart" />
    </div>
</div>