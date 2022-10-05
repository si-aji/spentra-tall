@unless($column['hidden'])
    <div
        @if (isset($column['tooltip']['text'])) title="{{ $column['tooltip']['text'] }}" @endif
                                                class="tw__relative tw__table-cell tw__h-12 tw__overflow-hidden tw__align-top" @include('datatables::style-width')>
        @if($column['sortable'])
            <button wire:click="sort('{{ $index }}')" class="tw__w-full tw__h-full tw__px-6 tw__py-3 tw__border-b tw__border-gray-200 tw__bg-gray-50 tw__text-left tw__text-xs tw__leading-4 tw__font-medium tw__text-gray-500 tw__uppercase tw__tracking-wider tw__flex tw__items-center focus:tw__outline-none @if($column['headerAlign'] === 'right') tw__justify-end @elseif($column['headerAlign'] === 'center') tw__justify-center @endif">
                <span class="tw__inline tw__">{{ str_replace('_', ' ', $column['label']) }}</span>
                <span class="tw__inline tw__text-xs tw__text-blue-400">
                    @if($sort === $index)
                        @if($direction)
                            <x-icons.chevron-up wire:loading.remove class="tw__w-6 tw__h-6 tw__text-green-600 tw__stroke-current" />
                        @else
                            <x-icons.chevron-down wire:loading.remove class="tw__w-6 tw__h-6 tw__text-green-600 tw__stroke-current" />
                        @endif
                    @endif
                </span>
            </button>
        @else
            <div class="tw__w-full tw__h-full tw__px-6 tw__py-3 tw__border-b tw__border-gray-200 tw__bg-gray-50 tw__text-left tw__text-xs tw__leading-4 tw__font-medium tw__text-gray-500 tw__uppercase tracking-wider tw__flex tw__items-center focus:tw__outline-none @if($column['headerAlign'] === 'right') tw__justify-end @elseif($column['headerAlign'] === 'center') tw__justify-center @endif">
                <span class="tw__inline tw__">{{ str_replace('_', ' ', $column['label']) }}</span>
            </div>
        @endif
    </div>
@endif
