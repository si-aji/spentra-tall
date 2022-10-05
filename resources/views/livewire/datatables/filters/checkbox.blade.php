<div
    @if (isset($column['tooltip']['text'])) title="{{ $column['tooltip']['text'] }}" @endif
    class="tw__flex tw__flex-col tw__items-center tw__h-full tw__px-6 tw__py-5 tw__overflow-hidden tw__text-xs tw__font-medium tw__tracking-wider tw__text-left tw__text-gray-500 tw__uppercase tw__align-top tw__bg-blue-100 tw__border-b tw__border-gray-200 tw__leading-4 tw__space-y-2 focus:tw__outline-none">
    <div>{{ __('SELECT ALL') }}</div>
    <div>
        <input
        type="checkbox"
        wire:click="toggleSelectAll"
        class="tw__w-4 tw__h-4 tw__mt-1 tw__text-blue-600 tw__form-checkbox tw__transition tw__duration-150 tw__ease-in-out"
        @if(count($selected) === $this->results->total()) checked @endif
        />
    </div>
</div>
