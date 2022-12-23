<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ isset($shtmlClass) ? $shtmlClass : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @hasSection('title')
            <title>{{ isset($parentTitle) && !empty($parentTitle) ? ($parentTitle).' | ' : '' }}@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ (isset($parentTitle) && !empty($parentTitle) ? ($parentTitle).' | ' : '').config('app.name') }}</title>
        @endif

        <!-- Favicon -->
		<link rel="shortcut icon" href="{{ asset('assets/icon.ico') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        @yield('baseFonts')

        {{-- <!-- Tailwind -->
        <link href="{{ mix('assets/css/tailwind.css') }}" rel="stylesheet"> --}}
        <!-- Style -->
        <link href="{{ mix('assets/css/app.css') }}" rel="stylesheet">
        <!-- CSS Plugins -->
        @yield('baseCSSPlugins')
        <!-- CSS Inline -->
        @yield('baseCSSInline')

        <!-- Manifest -->
        <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">

        <!-- Livewire -->
        @livewireStyles
        @livewireScripts

        {{-- <script>
            Livewire.onLoad(() => {
                let tz = '{{ \Session::get('SAUSER_TZ') ?? '' }}';
                let tzActual = (Intl.DateTimeFormat().resolvedOptions().timeZone).toString();
                let offset = '{{ \Session::get('SAUSER_TZ_OFFSET') ?? '' }}';
                let offsetActual = (new Date().getTimezoneOffset()).toString();

                console.log(`Tz: ${tz} / Actual: ${tzActual}`);
                console.log(`Offset: ${offset} / Actual: ${offsetActual}`);

                if(tz !== (Intl.DateTimeFormat().resolvedOptions().timeZone).toString() || offset !== (new Date().getTimezoneOffset()).toString()){
                    Livewire.emitTo('global-properties', 'setUserTimezone', tz, offset);
                }
            });
        </script> --}}
        @stack('javascript')

        {{-- PACE Loader --}}
        <link href="{{ mix('assets/plugins/pace-js/themes/purple/pace-theme-minimal.css') }}" rel="stylesheet">
        <script src="{{ mix('assets/plugins/pace-js/pace.js') }}"></script>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Google Analytic -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-251484487-1"></script>
        <!-- Google tag (gtag.js) -->
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-251484487-1');
        </script>

        <!-- Axios -->
        <script src="{{ mix('assets/js/axios/axios.min.js') }}"></script>
    </head>

    <body class="{{ isset($sbodyClass) ? $sbodyClass : '' }}">
        @yield('body')

        <!-- Script -->
        <script src="{{ mix('assets/js/app.js') }}"></script>
        <script>
            var selectedTz = '{{ \Session::get('SAUSER_TZ') }}';
            var selectedTzOffset = '{{ \Session::get('SAUSER_TZ_OFFSET') }}';
        </script>
        <!-- JS Plugins -->
        @yield('baseJsPlugins')
        <!-- Script Inline -->
        @yield('baseJsInline')
        @include('layouts.service-worker')
    </body>
</html>
