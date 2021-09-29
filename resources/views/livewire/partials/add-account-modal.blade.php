<x-jet-dialog-modal wire:model="newAccountModalOpen">
    <x-slot name="title">
        {{ __('New Account') }}
    </x-slot>

    <x-slot name="content">
        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    Name
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-lg flex rounded-md shadow-sm">
                        <input type="text" name="name" id="name"
                            class="flex-1 block w-full focus:ring-blue-500 focus:border-blue-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                    </div>
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="type" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    Account Type
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <select id="type" name="type"
                        class="max-w-lg block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                        @foreach ($this->availableAccountTypes as $slug => $type)
                            <option value="{{ $slug }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="type" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    Currency
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <select id="currency" name="currency"
                        class="max-w-lg block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                        <option value="USD">USD</option>
                    </select>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="closeNewAccountModal" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-buttons.branded-button class="ml-2" wire:click="createAccount" wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-buttons.branded-button>
    </x-slot>
</x-jet-dialog-modal>
