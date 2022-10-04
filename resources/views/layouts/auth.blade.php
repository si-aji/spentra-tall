@extends('layouts.base')

@section('body')
    <div class="tw__flex tw__flex-col tw__justify-center tw__min-h-screen tw__py-12 tw__bg-gray-50 sm:tw__px-6 lg:tw__px-8">
        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
@endsection
