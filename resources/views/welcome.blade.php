@extends('layouts.app')

@section('content')
    <div class="tw__flex tw__flex-col tw__justify-center tw__min-h-screen tw__py-12 tw__bg-gray-50 sm:tw__px-6 lg:tw__px-8">
        <div class="tw__absolute tw__top-0 tw__right-0 tw__mt-4 tw__mr-4">
            @if (Route::has('login'))
                <div class="tw__space-x-4">
                    @auth
                        <a
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="tw__font-medium tw__text-indigo-600 hover:tw__text-indigo-500 focus:tw__outline-none focus:tw__underline tw__transition tw__ease-in-out tw__duration-150"
                        >
                            Log out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="tw__font-medium tw__text-indigo-600 hover:tw__text-indigo-500 focus:tw__outline-none focus:tw__underline tw__transition tw__ease-in-out tw__duration-150">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="tw__font-medium tw__text-indigo-600 hover:tw__text-indigo-500 focus:tw__outline-none focus:tw__underline tw__transition tw__ease-in-out tw__duration-150">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <div class="tw__flex tw__items-center tw__justify-center">
            <div class="tw__flex tw__flex-col tw__justify-around">
                <div class="tw__space-y-6">
                    <a href="{{ route('home') }}">
                        <x-logo class="tw__w-auto tw__h-16 tw__mx-auto tw__text-indigo-600" />
                    </a>

                    <h1 class="tw__text-5xl tw__font-extrabold tw__tracking-wider tw__text-center tw__text-gray-600">
                        {{ config('app.name') }}
                    </h1>

                    <ul class="tw__list-reset">
                        <li class="tw__inline tw__px-4">
                            <a href="https://tailwindcss.com" class="tw__font-medium tw__text-indigo-600 hover:tw__text-indigo-500 focus:tw__outline-none focus:tw__underline tw__transition tw__ease-in-out tw__duration-150">Tailwind CSS</a>
                        </li>
                        <li class="tw__inline tw__px-4">
                            <a href="https://github.com/alpinejs/alpine" class="tw__font-medium tw__text-indigo-600 hover:tw__text-indigo-500 focus:tw__outline-none focus:tw__underline tw__transition tw__ease-in-out tw__duration-150">Alpine.js</a>
                        </li>
                        <li class="tw__inline px-4">
                            <a href="https://laravel.com" class="tw__font-medium tw__text-indigo-600 hover:tw__text-indigo-500 focus:tw__outline-none focus:tw__underline tw__transition tw__ease-in-out tw__duration-150">Laravel</a>
                        </li>
                        <li class="tw__inline px-4">
                            <a href="https://laravel-livewire.com" class="tw__font-medium tw__text-indigo-600 hover:tw__text-indigo-500 focus:tw__outline-none focus:tw__underline tw__transition tw__ease-in-out tw__duration-150">Livewire</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
