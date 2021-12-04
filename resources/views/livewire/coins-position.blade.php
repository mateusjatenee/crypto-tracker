<div wire:poll>
    <div class="px-4 py-2 bg-white shadow-sm rounded-md">
    <div class="w-full inline-flex justify-between py-1">
        <h3 class="text-xl leading-6 font-semibold tracking-tight text-gray-900 inline-flex">
            Position
        </h3>
    </div>
        <div>
            <ul role="list" class="divide-y divide-gray-200">
                @foreach ($account->positions() as $position)
                    <li class="py-4">
                        <div class="flex space-x-3">
                            <img class="h-6 w-6 rounded-full"
                                src="{{ $position->asset->iconUrl() }}"
                                alt="">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium">{{ $position->asset->code }}</h3>
                                    <p class="text-sm text-gray-500">{{ number_format($position->quantity(), 8) }}</p>
                                </div>
                                <p class="text-sm text-gray-700 font-semibold">${{ number_format($position->totalPosition()) }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach

                <!-- More items... -->
            </ul>
        </div>

    </div>

</div>
