@extends('layouts.base', [
    'sbodyClass' => '',
    'shtmlClass' => ''
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
    @yield('content')

    @isset($slot)
        {{ $slot }}
    @endisset
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
    <!-- Helpers -->
    <script src="{{ mix('assets/js/siaji.js') }}"></script>
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

    @yield('js_inline')
@endsection