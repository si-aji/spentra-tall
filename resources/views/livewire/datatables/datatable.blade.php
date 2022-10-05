<div>
    @includeIf($beforeTableSlot)
    <div class="tw__relative">
        <div class="tw__flex tw__items-center tw__justify-between tw__mb-1">
            <div class="tw__flex tw__items-center tw__h-10">
                @if($this->searchableColumns()->count())
                    <div class="tw__flex tw__rounded-lg tw__w-96 tw__shadow-sm">
                        <div class="tw__relative tw__flex-grow focus-within:tw__z-10">
                            <div class="tw__absolute tw__inset-y-0 tw__left-0 tw__flex tw__items-center tw__pl-3 tw__pointer-events-none">
                                <svg class="tw__w-5 tw__h-5 tw__text-gray-400" viewBox="0 0 20 20" stroke="currentColor" fill="none">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input wire:model.debounce.500ms="search" class="tw__block tw__w-full tw__py-3 tw__pl-10 tw__text-sm tw__border-gray-300 tw__leading-4 tw__rounded-md tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50 focus:tw__outline-none" placeholder="{{__('Search in')}} {{ $this->searchableColumns()->map->label->join(', ') }}" type="text" />
                            <div class="tw__absolute tw__inset-y-0 tw__right-0 tw__flex tw__items-center tw__pr-2">
                                <button wire:click="$set('search', null)" class="tw__text-gray-300 hover:tw__text-red-600 focus:tw__outline-none">
                                    <x-icons.x-circle class="tw__w-5 tw__h-5 tw__stroke-current" />
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if($this->activeFilters)
                <span class="tw__text-xl tw__text-blue-400 tw__uppercase">@lang('Filter active')</span>
            @endif

            <div class="tw__flex tw__flex-wrap tw__items-center tw__space-x-1">
                <x-icons.cog wire:loading class="tw__text-gray-400 tw__h-9 tw__w-9 tw__animate-spin" />

                @if($this->activeFilters)
                    <button wire:click="clearAllFilters" class="tw__flex tw__items-center tw__px-3 tw__text-xs tw__font-medium tw__tracking-wider tw__text-red-500 tw__uppercase tw__bg-white tw__border tw__border-red-400 tw__space-x-2 tw__rounded-md tw__leading-4 hover:tw__bg-red-200 focus:tw__outline-none"><span>{{ __('Reset') }}</span>
                        <x-icons.x-circle class="tw__m-2" />
                    </button>
                @endif

                @if(count($this->massActionsOptions))
                    <div class="tw__flex tw__items-center tw__justify-center tw__space-x-1">
                        <label for="datatables_mass_actions">{{ __('With selected') }}:</label>
                        <select wire:model="massActionOption" class="tw__px-3 tw__text-xs tw__font-medium tw__tracking-wider tw__uppercase tw__bg-white tw__border tw__border-green-400 tw__space-x-2 tw__rounded-md tw__leading-4 focus:tw__outline-none" id="datatables_mass_actions">
                            <option value="">{{ __('Choose...') }}</option>
                            @foreach($this->massActionsOptions as $group => $items)
                                @if(!$group)
                                    @foreach($items as $item)
                                        <option value="{{$item['value']}}">{{$item['label']}}</option>
                                    @endforeach
                                @else
                                    <optgroup label="{{$group}}">
                                        @foreach($items as $item)
                                            <option value="{{$item['value']}}">{{$item['label']}}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            @endforeach
                        </select>
                        <button
                            wire:click="massActionOptionHandler"
                            class="tw__flex tw__items-center tw__px-4 tw__py-2 tw__text-xs tw__font-medium tw__tracking-wider tw__text-green-500 tw__uppercase tw__bg-white tw__border tw__border-green-400 tw__rounded-md tw__leading-4 hover:tw__bg-green-200 focus:tw__outline-none" type="submit" title="Submit"
                        >Go</button>
                    </div>
                @endif

                @if($exportable)
                    <div x-data="{ init() {
                        window.livewire.on('startDownload', link => window.open(link, '_blank'))
                        } }" x-init="init">
                        <button wire:click="export" class="tw__flex tw__items-center tw__px-3 tw__text-xs tw__font-medium tw__tracking-wider tw__text-green-500 tw__uppercase tw__bg-white tw__border tw__border-green-400 tw__space-x-2 tw__rounded-md tw__leading-4 hover:tw__bg-green-200 focus:tw__outline-none"><span>{{ __('Export') }}</span>
                            <x-icons.excel class="tw__m-2" /></button>
                    </div>
                @endif

                @if($hideable === 'select')
                    @include('datatables::hide-column-multiselect')
                @endif

                @foreach ($columnGroups as $name => $group)
                    <button wire:click="toggleGroup('{{ $name }}')"
                            class="tw__px-3 tw__py-2 tw__text-xs tw__font-medium tw__tracking-wider tw__text-green-500 tw__uppercase tw__bg-white tw__border tw__border-green-400 tw__rounded-md tw__leading-4 hover:tw__bg-green-200 focus:tw__outline-none">
                        <span class="tw__flex tw__items-center tw__h-5">{{ isset($this->groupLabels[$name]) ? __($this->groupLabels[$name]) : __('Toggle :group', ['group' => $name]) }}</span>
                    </button>
                @endforeach
                @includeIf($buttonsSlot)
            </div>
        </div>

        @if($hideable === 'buttons')
            <div class="tw__p-2 tw__grid tw__grid-cols-8 tw__gap-2">
                @foreach($this->columns as $index => $column)
                    @if ($column['hideable'])
                        <button wire:click.prefetch="toggle('{{ $index }}')" class="tw__px-3 tw__py-2 tw__rounded tw__text-white tw__text-xs focus:tw__outline-none
                        {{ $column['hidden'] ? 'tw__g-blue-100 hover:tw__bg-blue-300 tw__text-blue-600' : 'tw__bg-blue-500 hover:tw__bg-blue-800' }}">
                            {{ $column['label'] }}
                        </button>
                    @endif
                @endforeach
            </div>
        @endif

        <div wire:loading.class="tw__opacity-50" class="tw__rounded-lg @unless($complex || $this->hidePagination) tw__rounded-b-none @endunless tw__shadow-lg tw__bg-white tw__max-w-screen tw__overflow-x-scroll tw__border-2 @if($this->activeFilters) tw__border-blue-500 @else tw__border-transparent @endif @if($complex) tw__rounded-b-none tw__border-b-0 @endif">
            <div>
                <div class="tw__table tw__min-w-full tw__align-middle">
                    @unless($this->hideHeader)
                        <div class="tw__table-row tw__divide-x tw__divide-gray-200">
                            @foreach($this->columns as $index => $column)
                                @if($hideable === 'inline')
                                    @include('datatables::header-inline-hide', ['column' => $column, 'sort' => $sort])
                                @elseif($column['type'] === 'checkbox')
                                    @unless($column['hidden'])
                                        <div class="tw__flex tw__justify-center tw__table-cell tw__w-32 tw__h-12 tw__px-6 tw__py-4 tw__overflow-hidden tw__text-xs tw__font-medium tw__tracking-wider tw__text-left tw__text-gray-500 tw__uppercase tw__align-top tw__border-b tw__border-gray-200 tw__bg-gray-50 tw__leading-4 focus:tw__outline-none">
                                            <div class="tw__px-3 tw__py-1 tw__rounded @if(count($selected)) tw__bg-orange-400 @else tw__bg-gray-200 @endif tw__text-white tw__text-center">
                                                {{ count($selected) }}
                                            </div>
                                        </div>
                                    @endunless
                                @else
                                    @include('datatables::header-no-hide', ['column' => $column, 'sort' => $sort])
                                @endif
                            @endforeach
                        </div>
                    @endunless
                    <div class="tw__table-row tw__bg-blue-100 tw__divide-x tw__divide-blue-200">
                        @foreach($this->columns as $index => $column)
                            @if($column['hidden'])
                                @if($hideable === 'inline')
                                    <div class="tw__table-cell tw__w-5 tw__overflow-hidden tw__align-top tw__bg-blue-100"></div>
                                @endif
                            @elseif($column['type'] === 'checkbox')
                                @include('datatables::filters.checkbox')
                            @elseif($column['type'] === 'label')
                                <div class="tw__table-cell tw__overflow-hidden tw__align-top">
                                    {{ $column['label'] ?? '' }}
                                </div>
                            @else
                                <div class="tw__table-cell tw__overflow-hidden tw__align-top">
                                    @isset($column['filterable'])
                                        @if( is_iterable($column['filterable']) )
                                            <div wire:key="{{ $index }}">
                                                @include('datatables::filters.select', ['index' => $index, 'name' => $column['label'], 'options' => $column['filterable']])
                                            </div>
                                        @else
                                            <div wire:key="{{ $index }}">
                                                @include('datatables::filters.' . ($column['filterView'] ?? $column['type']), ['index' => $index, 'name' => $column['label']])
                                            </div>
                                        @endif
                                    @endisset
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @foreach($this->results as $row)
                        <div class="tw__table-row tw__p-1 {{ $this->rowClasses($row, $loop) }}">
                            @foreach($this->columns as $column)
                                @if($column['hidden'])
                                    @if($hideable === 'inline')
                                        <div class="tw__table-cell tw__w-5 @unless($column['wrappable']) tw__whitespace-nowrap tw__truncate @endunless tw__overflow-hidden tw__align-top"></div>
                                    @endif
                                @elseif($column['type'] === 'checkbox')
                                    @include('datatables::checkbox', ['value' => $row->checkbox_attribute])
                                @elseif($column['type'] === 'label')
                                    @include('datatables::label')
                                @else

                                    <div class="tw__table-cell tw__px-6 tw__py-2 @unless($column['wrappable']) tw__whitespace-nowrap tw__truncate @endunless @if($column['contentAlign'] === 'right') tw__text-right @elseif($column['contentAlign'] === 'center') tw__text-center @else tw__text-left @endif {{ $this->cellClasses($row, $column) }}">
                                        {!! $row->{$column['name']} !!}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach

                    @if ($this->hasSummaryRow())
                        <div class="tw__table-row tw__p-1">
                            @foreach($this->columns as $column)
                                @unless($column['hidden'])
                                    @if ($column['summary'])
                                        <div class="tw__table-cell tw__px-6 tw__py-2 @unless ($column['wrappable']) tw__whitespace-nowrap tw__truncate @endunless @if($column['contentAlign'] === 'right') tw__text-right @elseif($column['contentAlign'] === 'center') tw__text-center @else tw__text-left @endif {{ $this->cellClasses($row, $column) }}">
                                            {{ $this->summarize($column['name']) }}
                                        </div>
                                    @else
                                        <div class="tw__table-cell"></div>
                                    @endif
                                @endunless
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            @if($this->results->isEmpty())
                <p class="tw__p-3 tw__text-lg tw__text-center">
                    {{ __("There's Nothing to show at the moment") }}
                </p>
            @endif
        </div>

        @unless($this->hidePagination)
            <div class="max-w-screen bg-white @unless($complex) rounded-b-lg @endunless border-4 border-t-0 border-b-0 @if($this->activeFilters) border-blue-500 @else border-transparent @endif">
                <div class="tw__items-center tw__justify-between tw__p-2 sm:tw__flex">
                    {{-- check if there is any data --}}
                    @if(count($this->results))
                        <div class="tw__flex tw__items-center tw__my-2 sm:tw__my-0">
                            <select name="perPage" class="tw__block tw__w-full tw__py-2 tw__pl-3 tw__pr-10 tw__mt-1 tw__text-base tw__border-gray-300 tw__form-select tw__leading-6 focus:tw__outline-none focus:tw__shadow-outline-blue focus:tw__border-blue-300 sm:tw__text-sm sm:tw__leading-5" wire:model="perPage">
                                @foreach(config('livewire-datatables.per_page_options', [ 10, 25, 50, 100 ]) as $per_page_option)
                                    <option value="{{ $per_page_option }}">{{ $per_page_option }}</option>
                                @endforeach
                                <option value="99999999">{{__('All')}}</option>
                            </select>
                        </div>

                        <div class="tw__my-4 sm:tw__my-0">
                            <div class="lg:tw__hidden">
                                <span class="tw__space-x-2">{{ $this->results->links('datatables::tailwind-simple-pagination') }}</span>
                            </div>

                            <div class="tw__justify-center tw__hidden lg:tw__flex">
                                <span>{{ $this->results->links('datatables::tailwind-pagination') }}</span>
                            </div>
                        </div>

                        <div class="tw__flex tw__justify-end tw__text-gray-600">
                            {{__('Results')}} {{ $this->results->firstItem() }} - {{ $this->results->lastItem() }} {{__('of')}}
                            {{ $this->results->total() }}
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    @if($complex)
        <div class="bg-gray-50 px-4 py-4 rounded-b-lg rounded-t-none shadow-lg border-2 @if($this->activeFilters) border-blue-500 @else border-transparent @endif @if($complex) border-t-0 @endif">
            <livewire:complex-query :columns="$this->complexColumns" :persistKey="$this->persistKey" :savedQueries="method_exists($this, 'getSavedQueries') ? $this->getSavedQueries() : null" />
        </div>
    @endif

    @includeIf($afterTableSlot)

    <span class="tw__hidden tw__text-sm tw__text-left tw__text-center tw__text-right tw__text-gray-900 tw__bg-gray-100 tw__bg-yellow-100 tw__leading-5 tw__bg-gray-50"></span>
</div>
