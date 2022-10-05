<div x-data="{ show: false }" class="tw__flex tw__flex-col tw__items-center">
    <div class="tw__flex tw__flex-col tw__items-center tw__relative">
        <button x-on:click="show = !show" class="tw__px-3 tw__py-2 tw__border tw__border-blue-400 tw__rounded-md tw__bg-white tw__text-blue-500 tw__text-xs tw__leading-4 tw__font-medium tw__uppercase tw__tracking-wider hover:tw__bg-blue-200 focus:tw__outline-none">
            <div class="tw__flex tw__items-center tw__h-5">
                {{ __('Show / Hide Columns')}}
            </div>
        </button>
        <div x-show="show" x-on:click.away="show = false" class="tw__z-50 tw__absolute tw__mt-16 tw__mr-4 tw__shadow-2xl tw__top-100 tw__bg-white tw__w-96 tw__right-0 tw__rounded tw__max-h-select tw__overflow-y-auto" x-cloak>
            <div class="tw__flex tw__flex-col tw__w-full">
                @foreach($this->columns as $index => $column)
                <div>
                    <div class="@unless($column['hidden']) hidden @endif cursor-pointer w-full border-gray-800 border-b bg-gray-700 text-gray-500 hover:bg-blue-600 hover:text-white" wire:click="toggle({{$index}})">
                        <div class="tw__relative tw__flex tw__w-full tw__items-center tw__p-2 tw__group">
                            <div class="tw__ tw__w-full tw__items-center tw__flex">
                                <div class="tw__mx-2 tw__leading-6">{{ $column['label'] }}</div>
                            </div>
                            <div class="tw__absolute tw__inset-y-0 tw__right-0 tw__pr-2 tw__flex tw__items-center">
                                <x-icons.check-circle class="tw__h-3 tw__w-3 tw__stroke-current tw__text-gray-700" />
                            </div>
                        </div>
                    </div>
                    <div class="@if($column['hidden']) hidden @endif cursor-pointer w-full border-gray-800 border-b bg-gray-700 text-white hover:bg-red-600" wire:click="toggle({{$index}})">
                        <div class="tw__relative tw__flex tw__w-full tw__items-center tw__p-2 tw__group">
                            <div class="tw__ tw__w-full tw__items-center tw__flex">
                                <div class="tw__mx-2 tw__leading-6">{{ $column['label'] }}</div>
                            </div>
                            <div class="tw__absolute tw__inset-y-0 tw__right-0 tw__pr-2 tw__flex tw__items-center">
                                <x-icons.x-circle class="tw__h-3 tw__w-3 tw__stroke-current tw__text-gray-700" />
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .top-100 {
        top: 100%
    }

    .bottom-100 {
        bottom: 100%
    }

    .max-h-select {
        max-height: 300px;
    }

</style>
