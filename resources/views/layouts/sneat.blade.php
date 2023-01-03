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
    <!-- Color Pickr -->
    <link href="{{ mix('assets/plugins/color-pickr/themes/classic.min.css') }}" rel="stylesheet">
    <link href="{{ mix('assets/plugins/color-pickr/themes/monolith.min.css') }}" rel="stylesheet">
    <link href="{{ mix('assets/plugins/color-pickr/themes/nano.min.css') }}" rel="stylesheet">

    @yield('css_plugins')
@endsection

{{-- CSS Inline --}}
@section('baseCSSInline')
    @yield('css_inline')
@endsection

{{-- Body --}}
@section('body')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar" x-data="{backdrop: false, user_timezone: new Date().getTimezoneOffset()}">
        <input type="hidden" name="user_timezone" id="user_timezone" x-bind:value="user_timezone" readonly>

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
                        @if (\Auth::check() && \Session::has('impersonate'))
                            {{-- Impersonate Alert --}}
                            <div class="alert alert-primary" role="alert">
                                <h1 class=" tw__text-xl tw__font-bold tw__mb-0">Impersonate Action</h1>
                                <span>You're seeing this message because you're currently <strong>Impersonating</strong>.</span>
                                <div class=" tw__block tw__mt-2">
                                    <div class=" tw__flex tw__items-center tw__gap-1 lg:tw__gap-2 tw__flex-wrap">
                                        <a href="{{ route('adm.index') }}" class="btn btn-primary btn-sm">Admin Dashboard</a>
                                        <a href="{{ route('sys.impersonate.stop') }}" class="btn btn-secondary btn-sm">Stop Impersonating</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @yield('breadcrumb')

                        <div class="content-wrapper">
                            @yield('content')
                        </div>
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

    {{-- Notification --}}
    @livewire(\App\Http\Livewire\Sys\Component\NotificationFeature::class, ['user' => \Auth::user()], key(generateRandomString()))

    {{-- Record Modal --}}
    @livewire(\App\Http\Livewire\Sys\Component\RecordModal::class, ['user' => \Auth::user()], key(generateRandomString()))
    @if (isset($componentRecordTemplate) && $componentRecordTemplate)
        {{-- Record Template --}}
        @livewire(\App\Http\Livewire\Sys\Component\RecordTemplateModal::class, ['user' => \Auth::user()], key(generateRandomString()))
    @endif

    {{-- Wallet Modal --}}
    @if (isset($componentWallet) && $componentWallet)
        @livewire(\App\Http\Livewire\Sys\Component\WalletModal::class, ['user' => \Auth::user()], key(generateRandomString()))
        {{-- Wallet Balance Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\WalletBalanceModal::class, ['user' => \Auth::user()], key(generateRandomString()))
    @endif
    @if (isset($componentWalletGroup) && $componentWalletGroup)
        {{-- Wallet Group Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\WalletGroupModal::class, ['user' => \Auth::user()], key(generateRandomString()))
    @endif
    @if (isset($componentWalletShare) && $componentWalletShare)
        {{-- Wallet Group Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\WalletShareModal::class, ['user' => \Auth::user()], key(generateRandomString()))
    @endif

    {{-- Planned Payment Record --}}
    @livewire(\App\Http\Livewire\Sys\Component\PlannedPaymentRecordModal::class, ['user' => \Auth::user()], key(generateRandomString()))
    @if (isset($componentPlannedPayment) && $componentPlannedPayment)
        {{-- Planned Payment Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\PlannedPaymentModal::class, ['user' => \Auth::user()], key(generateRandomString()))
    @endif
    @if (isset($componentCategory) && $componentCategory)
        {{-- Category Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\CategoryModal::class, ['user' => \Auth::user()], key(generateRandomString()))
    @endif
    @if (isset($componentTag) && $componentTag)
        {{-- Tag Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\TagModal::class, ['user' => \Auth::user()], key(generateRandomString()))
    @endif

    {{-- Shopping List --}}
    @if (isset($componentShoppingList) && $componentShoppingList)
        {{-- Shopping List Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\ShoppingListModal::class, ['user' => \Auth::user()], key(generateRandomString()))
        {{-- Shopping List Item Modal --}}
        @livewire(\App\Http\Livewire\Sys\Component\ShoppingListItemModal::class, ['user' => \Auth::user()], key(generateRandomString()))
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
    <!-- Color Pickr -->
    {{-- <script src="{{ mix('assets/plugins/color-pickr/pickr.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.es5.min.js"></script> --}}
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
    <script src="{{ mix('assets/plugins/moment/moment.min.js') }}"></script>
    {{-- <script async defer src="https://buttons.github.io/buttons.js"></script> --}}

    @yield('js_plugins')
@endsection

{{-- JS Inline --}}
@section('baseJsInline')
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

    {{-- Handle Keyboard Shortcut --}}
    <script>
        document.addEventListener('DOMContentLoaded', (e) => {
            if(document.getElementById('sia-search_input')){
                console.log("Search Input found");
                let searchField = document.getElementById('sia-search_input');
                if((navigator.userAgent).toLowerCase().includes('mac')){
                    searchField.setAttribute('placeholder', `(Control^ + /) Search...`);
                } else if((navigator.userAgent).toLowerCase().includes('windows')){
                    searchField.setAttribute('placeholder', `(CTRL + /) Search...`);
                } 

                window.onkeydown = (e) => {
                    var e = e || window.event; // for IE to cover IEs window event-object
                    if(e.ctrlKey && e.which == 191) {
                        if(document.activeElement === searchField){
                            return false;
                        }
                        searchField.focus();
                        searchField.select();
                        return false;
                    }
                }
            }
        });
    </script>

    {{-- Handle Session TZ --}}
    <script>
        // document.addEventListener('DOMContentLoaded', (e) => {
        //     Livewire.hook('message.sent', (message, component) => {
        //         console.log(message);
        //         console.log(component);
        //     });
        // });
    </script>

    @yield('js_inline')
@endsection