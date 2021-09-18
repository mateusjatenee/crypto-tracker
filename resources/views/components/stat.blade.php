<div class="px-4 py-5 sm:p-6">
    <dt class="text-base font-normal text-gray-900">
      {{ $name }}
    </dt>
    <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
      <div class="flex items-baseline text-2xl font-bold text-blue-500">
        $ {{ $formattedValue }}
      </div>

      <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 md:mt-2 lg:mt-0">
        <!-- Heroicon name: solid/arrow-sm-up -->
        <svg class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
        <span class="sr-only">
          Increased by
        </span>
        {{ $increaseInPercentage }}%
      </div>
    </dd>
  </div>