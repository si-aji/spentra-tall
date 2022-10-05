<div x-data class="tw__flex tw__flex-col">
    <input
        x-ref="input"
        type="text"
        class="tw__pr-8 tw__m-1 tw__text-sm tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50"
        wire:change="doTextFilter('{{ $index }}', $event.target.value)"
        x-on:change="$refs.input.value = ''"
    />
    <div class="tw__flex tw__flex-wrap tw__max-w-48 tw__space-x-1">
        @foreach($this->activeTextFilters[$index] ?? [] as $key => $value)
        <button wire:click="removeTextFilter('{{ $index }}', '{{ $key }}')" class="tw__m-1 tw__pl-1 tw__flex tw__items-center tw__uppercase tw__tracking-wide tw__bg-gray-300 tw__text-white hover:tw__bg-red-600 tw__rounded-full focus:tw__outline-none tw__text-xs tw__space-x-1">
            <span>{{ $this->getDisplayValue($index, $value) }}</span>
            <x-icons.x-circle  class="tw__h-5 tw__w-5 tw__stroke-current tw__text-red-500"  />
        </button>
        @endforeach
    </div>
</div>
