<div x-data class="tw__flex tw__flex-col">
    <div class="tw__flex">
        <select
            x-ref="select"
            name="{{ $name }}"
            class="tw__w-full tw__m-1 tw__text-sm tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50"
            wire:input="doSelectFilter('{{ $index }}', $event.target.value)"
            x-on:input="$refs.select.value=''"
        >
            <option value=""></option>
            @foreach($options as $value => $label)
                @if(is_object($label))
                    <option value="{{ $label->id }}">{{ $label->name }}</option>
                @elseif(is_array($label))
                    <option value="{{ $label['id'] }}">{{ $label['name'] }}</option>
                @elseif(is_numeric($value))
                    <option value="{{ $label }}">{{ $label }}</option>
                @else
                    <option value="{{ $value }}">{{ $label }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="tw__flex tw__flex-wrap tw__max-w-48 tw__space-x-1">
        @foreach($this->activeSelectFilters[$index] ?? [] as $key => $value)
        <button wire:click="removeSelectFilter('{{ $index }}', '{{ $key }}')" x-on:click="$refs.select.value=''"
            class="tw__m-1 tw__pl-1 tw__flex tw__items-center tw__uppercase tw__tracking-wide tw__bg-gray-300 tw__text-white hover:tw__bg-red-600 tw__rounded-full focus:tw__outline-none tw__text-xs tw__space-x-1">
            <span>{{ $this->getDisplayValue($index, $value) }}</span>
            <x-icons.x-circle />
        </button>
        @endforeach
    </div>
</div>
