<div class="tw__flex tw__justify-between">
    <!-- Previous Page Link -->
    @if ($paginator->onFirstPage())
    <div class="tw__w-32 tw__flex tw__justify-between tw__items-center tw__relative tw__px-4 tw__py-2 tw__border tw__border-gray-300 tw__text-sm tw__leading-5 tw__font-medium tw__rounded-md tw__text-gray-400 tw__bg-gray-50">
        <x-icons.arrow-left />
        {{ __('Previous')}}
    </div>
    @else
    <button wire:click="previousPage" id="pagination-mobile-page-previous" class="tw__w-32 tw__flex tw__justify-between tw__items-center tw__relative tw__px-4 tw__py-2 tw__border tw__border-gray-300 tw__text-sm tw__leading-5 tw__font-medium tw__rounded-md tw__text-gray-700 tw__bg-white hover:tw__text-gray-500 focus:tw__outline-none focus:tw__shadow-outline-blue focus:tw__border-blue-300 active:tw__bg-gray-100 active:tw__text-gray-700 tw__transition tw__ease-in-out tw__duration-150">
        <x-icons.arrow-left />
        {{ __('Previous')}}
    </button>
    @endif
    
    
    <!-- Next Page pnk -->
    @if ($paginator->hasMorePages())
    <button wire:click="nextPage" id="pagination-mobile-page-next" class="tw__w-32 tw__flex tw__justify-between tw__items-center tw__relative tw__items-center tw__px-4 tw__py-2 tw__border tw__border-gray-300 tw__text-sm tw__leading-5 tw__font-medium tw__rounded-md tw__text-gray-700 tw__bg-white hover:tw__text-gray-500 focus:tw__outline-none focus:tw__shadow-outline-blue focus:tw__border-blue-300 active:tw__bg-gray-100 active:tw__text-gray-700 tw__transition tw__ease-in-out tw__duration-150">
        {{ __('Next')}}
        <x-icons.arrow-right />
    </button>
    @else
    <div class="tw__w-32 tw__flex tw__justify-between tw__items-center tw__relative tw__px-4 tw__py-2 tw__border tw__border-gray-300 tw__text-sm tw__leading-5 tw__font-medium tw__rounded-md tw__text-gray-400 tw__bg-gray-50">
        {{ __('Next')}}
        <x-icons.arrow-right class="tw__inline" />
    </div>
    @endif
</div>    