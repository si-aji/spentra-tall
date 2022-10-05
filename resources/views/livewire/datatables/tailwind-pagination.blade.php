<div class="tw__flex tw__overflow-hidden tw__border tw__border-gray-300 tw__divide-x tw__divide-gray-300 tw__rounded tw__pagination">
    <!-- Previous Page Link -->
    @if ($paginator->onFirstPage())
    <button class="tw__relative tw__inline-flex tw__items-center tw__px-2 tw__py-2 tw__text-sm tw__font-medium tw__leading-5 tw__text-gray-500 tw__bg-white"
        disabled>
        <span>&laquo;</span>
    </button>
    @else
    <button wire:click="previousPage"
        id="pagination-desktop-page-previous"
        class="tw__relative tw__inline-flex tw__items-center tw__px-2 tw__py-2 tw__text-sm tw__font-medium tw__leading-5 tw__text-gray-500 tw__transition tw__duration-150 tw__ease-in-out tw__bg-white hover:tw__text-gray-400 focus:tw__z-10 focus:tw__outline-none focus:tw__border-blue-300 focus:tw__shadow-outline-blue active:tw__bg-gray-100 active:tw__text-gray-500">
        <span>&laquo;</span>
    </button>
    @endif

    <div class="tw__divide-x tw__divide-gray-300">
        @foreach ($elements as $element)
        @if (is_string($element))
        <button class="tw__relative tw__inline-flex tw__items-center tw__px-4 tw__py-2 tw__ml-px tw__text-sm tw__font-medium tw__leading-5 tw__text-gray-700 tw__bg-white" disabled>
            <span>{{ $element }}</span>
        </button>
        @endif

        <!-- Array Of Links -->

        @if (is_array($element))
        @foreach ($element as $page => $url)
        <button wire:click="gotoPage({{ $page }})"
                id="pagination-desktop-page-{{ $page }}"
                class="tw__-mr-1 tw__relative tw__inline-flex tw__items-center tw__px-4 tw__py-2 tw__text-sm tw__leading-5 tw__font-medium tw__text-gray-700 hover:tw__text-gray-500 focus:tw__z-10 focus:tw__outline-none focus:tw__border-blue-300 focus:tw__shadow-outline-blue active:tw__bg-gray-100 active:tw__text-gray-700 tw__transition tw__ease-in-out tw__duration-150 {{ $page === $paginator->currentPage() ? 'tw__bg-gray-200' : 'tw__bg-white' }}">
            {{ $page }}
            </button>
        @endforeach
        @endif
        @endforeach
    </div>

    <!-- Next Page Link -->
    @if ($paginator->hasMorePages())
    <button wire:click="nextPage"
        id="pagination-desktop-page-next"
        class="tw__relative tw__inline-flex tw__items-center tw__px-2 tw__py-2 tw__ml-px tw__text-sm tw__font-medium tw__leading-5 tw__text-gray-500 tw__transition tw__duration-150 tw__ease-in-out tw__bg-red hover:tw__text-gray-400 focus:tw__z-10 focus:tw__outline-none focus:tw__border-blue-300 focus:tw__shadow-outline-blue active:tw__bg-gray-100 active:tw__text-gray-500">
        <span>&raquo;</span>
    </button>
    @else
    <button
        class="tw__relative tw__inline-flex tw__items-center tw__px-2 tw__py-2 tw__ml-px tw__text-sm tw__font-medium tw__leading-5 tw__text-gray-500 tw__bg-white tw__"
        disabled><span>&raquo;</span></button>
    @endif
</div>
