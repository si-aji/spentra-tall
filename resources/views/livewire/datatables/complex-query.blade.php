<div x-data="{
    rules: @if($persistKey) $persist('').as('{{ $persistKey }}') @else '' @endif,
    init() {
        Livewire.on('complexQuery', rules => this.rules = rules)
        if (this.rules && this.rules !== '') {
            $wire.set('rules', this.rules)
            $wire.runQuery()
        }
    }
}" class=""
>
<div class="tw__my-4 tw__flex tw__justify-between tw__text-xl tw__uppercase tw__tracking-wide tw__font-medium tw__leading-none">
    <span>Query Builder</span>
    <span>@if($errors->any())
        <div class="tw__text-red-500">You have missing values in your rules</div>
    @endif</span>
</div>

@if(count($this->rules[0]['content']))
    <div class="my-4 px-4 py-2 bg-gray-500 whitespace-pre-wrap @if($errors->any())text-red-200 @else text-green-100 @endif rounded">{{ $this->rulesString }}@if($errors->any()) Invalid rules @endif</div>
@endif

<div>@include('datatables::complex-query-group', ['rules' => $rules, 'parentIndex' => null])</div>

@if(count($this->rules[0]['content']))
    @unless($errors->any())
        <div class="tw__pt-2 sm:tw__flex tw__w-full tw__justify-between">
            <div>
                {{-- <button class="tw__bg-blue-500 tw__px-3 tw__py-2 tw__rounded tw__text-white" wire:click="runQuery">Apply Query</button> --}}
            </div>
            <div class="tw__mt-2 sm:tw__mt-0 sm:tw__flex sm:tw__space-x-2">
                @isset($savedQueries)
                    <div class="tw__flex tw__items-center tw__space-x-2" x-data="{
                        name: null,
                        saveQuery() {
                            $wire.call('saveQuery', this.name)
                            this.name = null
                        }
                    }">
                        <input x-model="name" wire:loading.attr="disabled" x-on:keydown.enter="tw__saveQuery" placeholder="save as..." class="tw__flex-grow tw__px-3 tw__py-3 tw__border tw__text-sm tw__text-gray-900 tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__outline-none focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50" />
                        <button x-bind:disabled="! name" x-show="rules" x-on:click="saveQuery" class="tw__flex tw__items-center tw__space-x-2 tw__px-3 tw__py-0.5 tw__border tw__border-green-400 disabled:tw__border-gray-300 tw__rounded-md tw__bg-white tw__text-green-500 disabled:tw__text-gray-300 tw__text-xs tw__leading-4 tw__font-medium tw__uppercase tw__tracking-wider hover:tw__bg-green-200 disabled:hover:tw__bg-white focus:tw__outline-none disabled:tw__pointer-events-none">
                            <span>{{ __('Save') }}</span>
                            <span wire:loading.remove><x-icons.check-circle class="tw__m-2" /></span>
                            <span wire:loading><x-icons.cog class="tw__animate-spin tw__m-2" /></span>
                        </button>
                    </div>
                @endisset
                <button x-show="rules" wire:click="resetQuery" class="tw__flex tw__items-center tw__space-x-2 tw__px-3 tw__border tw__border-red-400 tw__rounded-md tw__bg-white tw__text-red-500 tw__text-xs tw__leading-4 tw__font-medium tw__uppercase tw__tracking-wider hover:tw__bg-red-200 focus:tw__outline-none">
                    <span>{{ __('Reset') }}</span>
                    <x-icons.x-circle class="tw__m-2" />
                </button>
            </div>
        </div>
    @endif

@endif
@if(count($savedQueries ?? []))
    <div>
        <div class="tw__mt-8 tw__my-4 tw__text-xl tw__uppercase tw__tracking-wide tw__font-medium tw__leading-none">Saved Queries</div>
        <div class="tw__grid md:tw__grid-cols-2 xl:tw__grid-cols-3 2xl:tw__grid-cols-4 tw__gap-2">
            @foreach($savedQueries as $saved)
                <div class="tw__flex" wire:key="{{ $saved['id'] }}">
                    <button wire:click="loadRules({{ json_encode($saved['rules']) }})" wire:loading.attr="disabled" class="tw__p-2 tw__flex-grow tw__flex tw__items-center tw__space-x-2 tw__px-3 tw__border tw__border-r-0 tw__border-blue-400 tw__rounded-md tw__rounded-r-none tw__bg-white tw__text-blue-500 tw__text-xs tw__leading-4 tw__font-medium tw__uppercase tw__tracking-wider hover:tw__bg-blue-200 focus:tw__outline-none">{{ $saved['name'] }}</button>
                    <button wire:click="deleteRules({{ $saved['id'] }})" wire:loading.attr="disabled" class="tw__p-2 tw__flex tw__items-center tw__space-x-2 tw__px-3 tw__border tw__border-red-400 tw__rounded-md tw__rounded-l-none tw__bg-white tw__text-red-500 tw__text-xs tw__leading-4 tw__font-medium tw__uppercase tw__tracking-wider hover:tw__bg-red-200 focus:tw__outline-none">
                        <x-icons.x-circle wire:loading.remove />
                        <x-icons.cog wire:loading class="tw__h-6 tw__w-6 tw__animate-spin" />
                    </button>
                </div>
            @endforeach
        </div>
    </div>
@endif
</div>
