<div wire:click.prefetch="toggle('{{ $index }}')"
     class="@if($column['hidden']) relative table-cell h-12 w-3 bg-blue-100 hover:bg-blue-300 overflow-none align-top group @else hidden @endif"
     style="min-width:12px; max-width:12px"
     >
     <button class="tw__relative tw__h-12 tw__w-3 focus:tw__outline-none">
         <span
             class="tw__w-32 tw__hidden group-hover:tw__inline-block tw__absolute tw__z-10 tw__top-0 tw__left-0 tw__ml-3 tw__bg-blue-300 tw__font-medium tw__leading-4 tw__text-xs tw__text-left tw__text-blue-700 tw__tracking-wider tw__transform tw__uppercase focus:tw__outline-none">
             {{ str_replace('_', ' ', $column['label']) }}
         </span>
     </button>
     <svg class="tw__absolute tw__text-blue-100 tw__fill-current tw__w-full tw__inset-x-0 tw__bottom-0"
          viewBox="0 0 314.16 207.25">
         <path stroke-miterlimit="10" d="M313.66 206.75H.5V1.49l157.65 204.9L313.66 1.49v205.26z" />
     </svg>
</div>
<div class="@if($column['hidden']) hidden @else relative h-12 overflow-hidden align-top flex table-cell @endif" @include('datatables::style-width')>

    @if($column['sortable'])
        <button wire:click="sort('{{ $index }}')"
                class="tw__w-full tw__h-full tw__px-6 tw__py-3 tw__border-b tw__border-gray-200 tw__bg-gray-50 tw__text-xs tw__leading-4 tw__font-medium tw__text-gray-500 tw__uppercase tw__tracking-wider tw__flex tw__justify-between tw__items-center focus:tw__outline-none">
            <span class="inline flex-grow @if($column['headerAlign'] === 'right') text-right @elseif($column['headerAlign'] === 'center') text-center @endif"">{{ str_replace('_', ' ', $column['label']) }}</span>
            <span class="tw__inline tw__text-xs tw__text-blue-400">
            @if($sort === $index)
                @if($direction)
                    <x-icons.chevron-up class="tw__h-6 tw__w-6 tw__text-green-600 tw__stroke-current" />
                @else
                    <x-icons.chevron-down class="tw__h-6 tw__w-6 tw__text-green-600 tw__stroke-current" />
                @endif
            @endif
            </span>
        </button>
    @else
        <div class="tw__w-full tw__h-full tw__px-6 tw__py-3 tw__border-b tw__border-gray-200 tw__bg-gray-50 tw__text-xs tw__leading-4 tw__font-medium tw__text-gray-500 tw__uppercase tw__tracking-wider tw__flex tw__justify-between tw__items-center focus:tw__outline-none">
            <span class="inline flex-grow @if($column['headerAlign'] === 'right') text-right @elseif($column['headerAlign'] === 'center') text-center @endif"">{{ str_replace('_', ' ', $column['label']) }}</span>
        </div>
    @endif

    @if ($column['hideable'])
        <button wire:click.prefetch="toggle('{{ $index }}')"
                class="tw__absolute tw__bottom-1 tw__right-1 focus:tw__outline-none">
            <x-icons.arrow-circle-left class="tw__h-3 tw__w-3 tw__text-gray-300 hover:tw__text-blue-400" />
        </button>
    @endif
</div>
