<div x-data class="tw__flex tw__flex-col">
    <select
        x-ref="select"
        name="{{ $name }}"
        class="tw__m-1 tw__text-sm tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50"
        wire:input="doBooleanFilter('{{ $index }}', $event.target.value)"
        x-on:input="$refs.select.value=''"
    >
        <option value=""></option>
        <option value="0">{{ __('No') }}</option>
        <option value="1">{{ __('Yes') }}</option>
    </select>

    <div class="tw__flex tw__flex-wrap tw__max-w-48 tw__space-x-1">
        @isset($this->activeBooleanFilters[$index])
        @if($this->activeBooleanFilters[$index] == 1)
        <button wire:click="removeBooleanFilter('{{ $index }}')"
            class="tw__m-1 tw__pl-1 tw__flex tw__items-center tw__uppercase tw__tracking-wide tw__bg-gray-300 tw__text-white hover:tw__bg-red-600 tw__rounded-full focus:tw__outline-none tw__text-xs tw__space-x-1">
            <span>{{ __('YES') }}</span>
            <x-icons.x-circle />
        </button>
        @elseif(strlen($this->activeBooleanFilters[$index]) > 0)
        <button wire:click="removeBooleanFilter('{{ $index }}')"
            class="tw__m-1 tw__pl-1 tw__flex tw__items-center tw__uppercase tw__tracking-wide tw__bg-gray-300 tw__text-white hover:tw__bg-red-600 tw__rounded-full focus:tw__outline-none tw__text-xs tw__space-x-1">
            <span>{{ __('No') }}</span>
            <x-icons.x-circle />
        </button>
        @endif
        @endisset
    </div>
</div>
