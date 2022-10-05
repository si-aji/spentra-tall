<div class="tw__flex tw__flex-col">
    <div x-data class="tw__relative tw__flex">
        <input
            x-ref="min"
            type="number"
            wire:input.debounce.500ms="doNumberFilterStart('{{ $index }}', $event.target.value)"
            class="tw__w-full tw__pr-8 tw__m-1 tw__text-sm tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50"
            placeholder="{{ __('MIN') }}"
        />
        <div class="tw__absolute tw__inset-y-0 tw__right-0 tw__pr-2 tw__flex tw__items-center">
            <button x-on:click="$refs.min.value=''" wire:click="doNumberFilterStart('{{ $index }}', '')" class="tw__mb-0.5 tw__pr-1 tw__flex tw__text-gray-400 hover:tw__text-red-600 focus:tw__outline-none" tabindex="-1">
                <x-icons.x-circle class="tw__h-5 tw__w-5 tw__stroke-current" />
            </button>
        </div>
    </div>

    <div x-data class="tw__relative tw__flex">
        <input
            x-ref="max"
            type="number"
            wire:input.debounce.500ms="doNumberFilterEnd('{{ $index }}', $event.target.value)"
            class="tw__w-full tw__pr-8 tw__m-1 tw__text-sm tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50"
            placeholder="{{ __('MAX') }}"
        />
        <div class="tw__absolute tw__inset-y-0 tw__right-0 tw__pr-2 tw__flex tw__items-center">
            <button x-on:click="$refs.max.value=''" wire:click="doNumberFilterEnd('{{ $index }}', '')" class="tw__mb-0.5 tw__pr-1 tw__flex tw__text-gray-400 hover:tw__text-red-600 focus:tw__outline-none" tabindex="-1">
                <x-icons.x-circle class="tw__h-5 tw__w-5 tw__stroke-current" />
            </button>
        </div>
    </div>
</div>
