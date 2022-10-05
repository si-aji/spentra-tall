<div x-data="{ open: {{ isset($open) && $open ? 'true' : 'false' }}, working: false }" x-cloak wire:key="delete-{{ $value }}">
    <span x-on:click="open = true">
        <button class="tw__p-1 tw__text-red-600 tw__rounded hover:tw__bg-red-600 hover:tw__text-white"><x-icons.trash /></button>
    </span>

    <div x-show="open"
        class="tw__fixed tw__z-50 tw__bottom-0 tw__inset-x-0 tw__px-4 tw__pb-4 sm:tw__inset-0 sm:tw__flex sm:tw__items-center sm:tw__justify-center">
        <div x-show="open" x-transition:enter="tw__ease-out tw__duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="tw__ease-in tw__duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="tw__fixed tw__inset-0 tw__transition-opacity">
            <div class="tw__absolute tw__inset-0 tw__bg-gray-500 tw__opacity-75"></div>
        </div>

        <div x-show="open" x-transition:enter="tw__ease-out tw__duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="tw__ease-in tw__duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="tw__relative tw__bg-gray-100 tw__rounded-lg tw__px-4 tw__pt-5 tw__pb-4 tw__overflow-hidden tw__shadow-xl tw__transform tw__transition-all sm:tw__max-w-lg sm:tw__w-full sm:tw__p-6">
            <div class="tw__hidden sm:tw__block tw__absolute tw__top-0 tw__right-0 tw__pt-4 tw__pr-4">
                <button @click="open = false" type="button"
                    class="tw__text-gray-400 hover:tw__text-gray-500 focus:tw__outline-none focus:tw__text-gray-500 tw__transition tw__ease-in-out tw__duration-150">
                    <svg class="tw__h-6 tw__w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="tw__w-full">
                <div class="tw__mt-3 tw__text-center">
                    <h3 class="tw__text-lg tw__leading-6 tw__font-medium tw__text-gray-900">
                        {{ __('Delete') }} {{ $value }}
                    </h3>
                    <div class="tw__mt-2">
                        <div class="tw__mt-10 tw__text-gray-700">
                            {{ __('Are you sure?')}}
                        </div>
                        <div class="tw__mt-10 tw__flex tw__justify-center">
                            <span class="tw__mr-2">
                                <button x-on:click="open = false" x-bind:disabled="working" class="tw__w-32 tw__shadow-sm tw__inline-flex tw__justify-center tw__items-center tw__px-3 tw__py-2 tw__border tw__border-transparent tw__text-sm tw__leading-4 tw__font-medium tw__rounded-md tw__text-white tw__bg-gray-600 hover:tw__bg-gray-700 focus:tw__outline-none focus:tw__border-gray-700 focus:tw__shadow-outline-teal active:tw__bg-gray-700 tw__transition tw__ease-in-out tw__duration-150">
                                    {{ __('No')}}
                                </button>
                            </span>
                            <span x-on:click="working = !working">
                                <button wire:click="delete({{ $value }})" class="tw__w-32 tw__shadow-sm tw__inline-flex tw__justify-center tw__items-center tw__px-3 tw__py-2 tw__border tw__border-transparent tw__text-sm tw__leading-4 tw__font-medium tw__rounded-md tw__text-white tw__bg-red-600 hover:tw__bg-red-700 focus:tw__outline-none focus:tw__border-red-700 focus:tw__shadow-outline-teal active:tw__bg-red-700 tw__transition tw__ease-in-out tw__duration-150">
                                    {{ __('Yes')}}
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
