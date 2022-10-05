<div x-data class="tw__flex tw__flex-col">
    <div class="tw__w-full tw__relative tw__flex">
        <input x-ref="start" class="tw__w-full tw__pr-8 tw__m-1 tw__text-sm tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50" type="date"
            wire:change="doDateFilterStart('{{ $index }}', $event.target.value)" style="padding-bottom: 5px" />
        <div class="tw__absolute tw__inset-y-0 tw__right-0 tw__pr-2 tw__flex tw__items-center">
            <button x-on:click="$refs.start.value=''" wire:click="doDateFilterStart('{{ $index }}', '')" class="tw__mb-0.5 tw__pr-1 tw__flex tw__text-gray-400 hover:tw__text-red-600 focus:tw__outline-none" tabindex="-1">
                <x-icons.x-circle class="tw__h-5 tw__w-5 tw__stroke-current" />
            </button>
        </div>
    </div>
    <div class="tw__w-full tw__relative tw__flex tw__items-center">
        <input x-ref="end" class="tw__w-full tw__pr-8 tw__m-1 tw__text-sm tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50" type="date"
            wire:change="doDateFilterEnd('{{ $index }}', $event.target.value)" style="padding-bottom: 5px" />
        <div class="tw__absolute tw__inset-y-0 tw__right-0 tw__pr-2 tw__flex tw__items-center">
            <button x-on:click="$refs.end.value=''" wire:click="doDateFilterEnd('{{ $index }}', '')" class="tw__mb-0.5 tw__pr-1 tw__flex tw__text-gray-400 hover:tw__text-red-600 focus:tw__outline-none" tabindex="-1">
                <x-icons.x-circle class="tw__h-5 tw__w-5 tw__stroke-current" />
            </button>
        </div>
    </div>
</div>
