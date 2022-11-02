@if ($paginator->hasPages())
    <nav role="navigation">
        <ul class="pagination tw__mb-0">
            @if ($paginator->onFirstPage())
                <li class="page-item prev disabled">
                    <span type="button" class="page-link">
                        <i class="tf-icon bx bx-chevrons-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item prev">
                    <button wire:click="previousPage" class="page-link">
                        <i class="tf-icon bx bx-chevrons-left"></i>
                    </button>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <button type="button" class="page-link">{{ $element }}</button>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        {{-- @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <button type="button" class="page-link">{{ $page }}</button>
                            </li>
                        @else
                            <li class="page-item">
                                <button wire:click="gotoPage({{ $page }})" class="page-link">{{ $page }}</button>
                            </li>
                        @endif --}}

                        <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                            <button wire:click="gotoPage({{ $page }})" class="page-link">{{ $page }}</button>
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item next">
                    <button wire:click="nextPage" class="page-link">
                        <i class="tf-icon bx bx-chevrons-right"></i>
                    </button>
                </li>
            @else
                <li class="page-item next disabled">
                    <span type="button" class="page-link">
                        <i class="tf-icon bx bx-chevrons-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif