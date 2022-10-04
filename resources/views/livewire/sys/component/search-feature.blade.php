<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class=" tw__fixed tw__pt-4 tw__z-[1050] tw__w-full lg:tw__w-[calc(100%-calc(0.625rem*2)-15rem)]" x-data="{result: false}">
        <div class="container-xxl">
            <!-- Navbar -->
            <nav class=" tw__w-full layout-navbar navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme tw__inline-flex tw__m-0" id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                </div>
        
                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Search -->
                    <div class="navbar-nav align-items-center tw__w-full">
                        <div class="nav-item d-flex align-items-center tw__w-full">
                            <i class="bx bx-search fs-4 lh-0" id="toggle-search"></i>
                            <input
                                type="text"
                                class="form-control border-0 shadow-none tw__w-full"
                                placeholder="(CTRL + /) Search..."
                                aria-label="(CTRL + /) Search..."
                                id="sia-search_input"
                                x-on:focusout="backdrop = false; result = false"
                                x-on:focusin="(($event.target.value).length > 2 ? backdrop = true : backdrop = false);($event.target.value).length > 2 ? result = true : result = false"
                                @input.debounce="(($event.target.value).length > 2 ? (backdrop = true) : (backdrop = false)); ($event.target.value).length > 2 ? (result = true) : (result = false);sidebarSearch($event)"
                            />
                        </div>
                    </div>
                    <!-- /Search -->
        
                    <ul class="navbar-nav flex-row align-items-center">
                        <!-- Quick links  -->
                        <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="modal" data-bs-tt="tooltip" data-bs-target="#modal-record" data-bs-placement="bottom" title="Add new Record">
                                <i class='bx bx-sm bx-plus-circle'></i>
                            </a>
                        </li>
                        <!-- Quick links -->
                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="{{ $avatar }}" alt class="w-px-40 h-px-40 tw__object-cover rounded-circle" />
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar avatar-online">
                                                    <img src="{{ $avatar }}" alt class="w-px-40 h-px-40 tw__object-cover rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-semibold d-block">{{ \Auth::user()->name }}</span>
                                                <small class="text-muted">{{ \Auth::user()->email ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('sys.profile.index') }}">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bx bx-cog me-2"></i>
                                        <span class="align-middle">Settings</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a class="dropdown-item" href="#">
                                        <span class="d-flex align-items-center align-middle">
                                            <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                            <span class="flex-grow-1 align-middle">Billing</span>
                                            <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                                        </span>
                                    </a>
                                </li> --}}
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bx bx-power-off me-2"></i>
                                        <span class="align-middle">Log Out</span>
                                    </a>
    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>
            </nav>
            <!-- / Navbar -->
        
            <div class=" tw__mt-2" id="search-result" x-show="result">
                <!-- Search Result -->
                <div class=" tw__bg-white tw__rounded tw__p-4">
                    <div class="search-result">
                        {{-- Show result --}}
                        {{-- Not found --}}
                        {{-- <span class=" tw__flex tw__items-center tw__gap-2"><i class='bx bx-info-circle'></i>No result found</span> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize menu togglers and bind click on each
            let menuToggler = document.querySelectorAll('.layout-menu-toggle');
            menuToggler.forEach(item => {
                item.addEventListener('click', event => {
                    event.preventDefault();
                    window.Helpers.toggleCollapsed();
                });
            });
        });

        function sidebarSearch(el){
            let keyword = (el.target.value).toUpperCase();
            let searchResult = document.querySelector('#search-result .search-result');
    
            // Append Loading
            searchResult.innerHTML = `
                <span class=" tw__flex tw__items-center tw__gap-2"><i class='bx bx-loader-alt tw__animate-spin'></i>Loading...</span>
            `;
            // console.log(searchResult);
        }
    </script>
@endpush