@extends('layouts.base', [
    'sbodyClass' => '',
    'shtmlClass' => 'light-style layout-menu-fixed'
])

{{-- Fonts --}}
@section('baseFonts')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    {{-- Icons --}}
    <link rel="stylesheet" href="{{ mix('assets/themes/sneat/fonts/boxicons.css') }}" />
@endsection

{{-- CSS Plugins --}}
@section('baseCSSPlugins')
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ mix('assets/themes/sneat/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ mix('assets/themes/sneat/css/siaji.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ mix('assets/themes/sneat/css/theme-default.css') }}" class="template-customizer-theme-css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ mix('assets/themes/sneat/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ mix('assets/themes/sneat/libs/apex-charts/apex-charts.css') }}" />

    <!-- Flatpickr -->
    <link href="{{ mix('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <!-- Choices Js -->
    {{-- <link href="{{ mix('assets/plugins/choices.js/base.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ mix('assets/plugins/choices.js/choices.min.css') }}" rel="stylesheet">
    <!-- Sweetalert2 -->
    <link href="{{ mix('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">

    @yield('css_plugins')
@endsection

{{-- CSS Inline --}}
@section('baseCSSInline')
    @yield('css_inline')
@endsection

{{-- Body --}}
@section('body')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar" x-data="{backdrop: false}">
        <div class="layout-container">
            <!-- Layout Sidebar -->
            @include('layouts.partials.sys.sidebar')

            <!-- Layout container -->
            <div class="layout-page before:tw__fixed before:tw__block before:tw__w-full before:tw__h-4 before:tw__bg-gradient-to-t tw__to-[rgba(245,245,249,.6)] before:tw__backdrop-blur-[10px] before:tw__z-[9]">
                <!-- Layout Navbar -->
                @include('layouts.partials.sys.navbar')

                <!-- Content wrapper -->
                <div class="content-wrapper tw__mt-20">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('breadcrumb')
                        @yield('content')
                    </div>

                    <!-- Layout Footer -->
                    @include('layouts.partials.sys.footer')
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    @isset($slot)
        {{ $slot }}
    @endisset

    {{-- Record Modal --}}
    @livewire(\App\Http\Livewire\Sys\Component\RecordModal::class, ['user' => \Auth::user()], key(\Auth::user()->id))

    @if (isset($componentWallet) && $componentWallet)
        {{-- Wallet Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\WalletModal::class, ['user' => \Auth::user()], key(\Auth::user()->id))
        {{-- Wallet Balance Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\WalletBalanceModal::class, ['user' => \Auth::user()], key(\Auth::user()->id))
    @endif
    @if (isset($componentWalletGroup) && $componentWalletGroup)
        {{-- Wallet Group Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\WalletGroupModal::class, ['user' => \Auth::user()], key(\Auth::user()->id))
    @endif
    @if (isset($componentCategory) && $componentCategory)
        {{-- Category Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\CategoryModal::class, ['user' => \Auth::user()], key(\Auth::user()->id))
    @endif
    @if (isset($componentTag) && $componentTag)
        {{-- Tag Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\TagModal::class, ['user' => \Auth::user()], key(\Auth::user()->id))
    @endif
@endsection


@push('javascript')
    <!-- Lightbox -->
    <script src="{{ mix('assets/plugins/fslightbox/fslightbox.js') }}"></script>
    <!-- Flatpickr -->
    <script src="{{ mix('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <!-- Choices Js -->
    <script src="{{ mix('assets/plugins/choices.js/choices.min.js') }}"></script>
    <!-- iMask -->
    <script src="{{ mix('assets/plugins/imask/imask.js') }}"></script>
    <!-- Sweetalert2 -->
    <script src="{{ mix('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    @endpush

{{-- JS Plugins --}}
@section('baseJsPlugins')
    <script src="{{ mix('assets/js/shortcut.js') }}"></script>
    <script src="{{ mix('assets/js/siaji.js') }}"></script>
    <!-- Helpers -->
    <script src="{{ mix('assets/themes/sneat/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ mix('assets/themes/sneat/js/config.js') }}"></script>

    <!-- Core -->
    <script src="{{ mix('assets/themes/sneat/libs/popper/popper.js') }}"></script>
    <script src="{{ mix('assets/themes/sneat/js/bootstrap.js') }}"></script>
    <script src="{{ mix('assets/themes/sneat/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ mix('assets/themes/sneat/js/menu.js') }}"></script>

    <!-- Vendor -->
    <script src="{{ mix('assets/themes/sneat/libs/apex-charts/apexcharts.js') }}vendor/"></script>
    <script src="{{ mix('assets/themes/sneat/js/main.js') }}"></script>
    {{-- <script async defer src="https://buttons.github.io/buttons.js"></script> --}}

    @yield('js_plugins')
@endsection

{{-- JS Inline --}}
@section('baseJsInline')
    {{-- <script>
        var searchTimeout = null;
        if(document.getElementById('sia-search_input')){
            window.addEventListener('DOMContentLoaded', (e) => {
                shortcut.set({
                    "control-/" : () => { 
                        document.getElementById('sia-search_input').focus()
                    },
                });
            });

            if(document.getElementById('search-result')){
                document.getElementById('sia-search_input').addEventListener('keyup', function(e){
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        if((e.target.value).length >= 3){
                            // Show search result
                            document.getElementById('search-result').classList.remove('tw__hidden');
                            document.getElementById('search-result').classList.add('tw__block');
                            // Show Overlay
                            if(document.querySelector('.content-backdrop')){
                                document.querySelector('.content-backdrop').classList.remove('fade');
                                document.querySelector('.content-backdrop').classList.add('show');
                            }
                        } else {
                            // Hide search result
                            document.getElementById('search-result').classList.remove('tw__block');
                            document.getElementById('search-result').classList.add('tw__hidden');
                            // Show Overlay
                            if(document.querySelector('.content-backdrop')){
                                document.querySelector('.content-backdrop').classList.remove('show');
                                document.querySelector('.content-backdrop').classList.add('fade');
                            }
                        }
                    }, 500);
                });
                document.getElementById('sia-search_input').addEventListener('focusin', function(e){
                    if((e.target.value).length >= 3){
                        // Show search result
                        document.getElementById('search-result').classList.remove('tw__hidden');
                        document.getElementById('search-result').classList.add('tw__block');
                        // Show Overlay
                        if(document.querySelector('.content-backdrop')){
                            document.querySelector('.content-backdrop').classList.remove('fade');
                            document.querySelector('.content-backdrop').classList.add('show');
                        }
                    }

                    if(document.getElementById('toggle-search')){
                        document.getElementById('toggle-search').classList.remove('bx-search');
                        document.getElementById('toggle-search').classList.add('bx-x');
                    }
                });
                document.getElementById('sia-search_input').addEventListener('focusout', function(e){
                    // Hide search result
                    document.getElementById('search-result').classList.remove('tw__block');
                    document.getElementById('search-result').classList.add('tw__hidden');
                    // Hide Overlay
                    if(document.querySelector('.content-backdrop')){
                        document.querySelector('.content-backdrop').classList.remove('show');
                        document.querySelector('.content-backdrop').classList.add('fade');
                    }

                    setTimeout(() => {
                        if(document.getElementById('toggle-search') && document.getElementById('toggle-search').classList.contains('bx-x')){
                            document.getElementById('toggle-search').classList.remove('bx-x');
                            document.getElementById('toggle-search').classList.add('bx-search');
                        }
                    }, 200)
                });
                document.getElementById('toggle-search').addEventListener('click', (e) => {   
                    console.log(e.target.classList.contains('bx-search') ? 'TRUE' : 'FALSE');
                    console.log(e.target.classList);

                    if(e.target.classList.contains('bx-search')){
                        document.getElementById('sia-search_input').focus();
                        e.target.classList.remove('bx-search');
                        e.target.classList.add('bx-x');
                    } else {
                        document.getElementById('sia-search_input').value = '';
                        e.target.classList.remove('bx-x');
                        e.target.classList.add('bx-search');
                    }
                });
            }
        }
    </script> --}}

    {{-- Handle tooltip --}}
    <script>
        if(document.querySelectorAll('[data-bs-tt="tooltip"]').length > 0){
            document.querySelectorAll('[data-bs-tt="tooltip"]').forEach((el) => {
                new bootstrap.Tooltip(el);
            });
        }
    </script>

    {{-- Handle Action Result --}}
    <script>
        window.addEventListener('wire-action', (event) => {
            let result = event.detail;
            console.log(result);

            Swal.fire({
                icon: result.status,
                title: `Action: ${result.action}`,
                text: result.message,
            });
        });
    </script>

    @yield('js_inline')
@endsection