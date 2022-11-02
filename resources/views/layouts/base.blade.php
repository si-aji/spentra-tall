<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ isset($shtmlClass) ? $shtmlClass : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @hasSection('title')
            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endif

        <!-- Favicon -->
		<link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        @yield('baseFonts')

        <!-- Tailwind -->
        <link href="{{ mix('assets/css/tailwind.css') }}" rel="stylesheet">
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

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body class="{{ isset($sbodyClass) ? $sbodyClass : '' }}">
        @yield('body')

        <!-- Script -->
        <script src="{{ mix('assets/js/app.js') }}"></script>
        <!-- JS Plugins -->
        @yield('baseJsPlugins')
        <!-- Script Inline -->
        @yield('baseJsInline')
        @include('layouts.service-worker')
    </body>
</html>
