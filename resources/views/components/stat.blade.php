<div class="px-4 py-5 sm:p-6">
    <dt class="text-base font-normal text-gray-900">
      {{ $name }}
    </dt>
    <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
      <div class="flex items-baseline text-2xl font-bold {{ $value > 0 ? 'text-blue-500' : 'text-red-500' }}">
        $ {{ $formattedValue }}
      </div>
      @if ($increase)
        <x-percentage-pill :percentage="$increase" />
      @endif
    </dd>
  </div>