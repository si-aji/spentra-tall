@section('title', 'Sign in to your account')

<div>
    <div class="sm:tw__mx-auto sm:tw__w-full sm:tw__max-w-md">
        <a href="{{ route('home') }}">
            <x-logo class="tw__w-auto tw__h-16 tw__mx-auto tw__text-indigo-600" />
        </a>

        <h2 class="tw__mt-6 tw__text-3xl tw__font-extrabold tw__text-center tw__text-gray-900 tw__leading-9">
            Sign in to your account
        </h2>
        @if (Route::has('register'))
            <p class="tw__mt-2 tw__text-sm tw__text-center tw__text-gray-600 tw__leading-5 tw__max-w">
                Or
                <a href="{{ route('register') }}" class="tw__font-medium tw__text-indigo-600 hover:tw__text-indigo-500 focus:tw__outline-none focus:tw__underline tw__transition tw__ease-in-out tw__duration-150">
                    create a new account
                </a>
            </p>
        @endif
    </div>

    <div class="tw__mt-8 sm:tw__mx-auto sm:tw__w-full sm:tw__max-w-md">
        <div class="tw__px-4 tw__py-8 tw__bg-white tw__shadow sm:tw__rounded-lg sm:tw__px-10">
            <form wire:submit.prevent="authenticate">
                <div>
                    <label for="email" class="tw__block tw__text-sm tw__font-medium tw__text-gray-700 tw__leading-5">
                        Email / Username
                    </label>

                    <div class="tw__mt-1 tw__rounded-md tw__shadow-sm">
                        <input wire:model.defer="email" id="email" name="email" type="text" placeholder="Email / Username" required autofocus class="tw__appearance-none tw__block tw__w-full tw__px-3 tw__py-2 tw__border tw__border-gray-300 tw__rounded-md tw__placeholder-gray-400 focus:tw__outline-none focus:tw__ring-blue focus:tw__border-blue-300 tw__transition tw__duration-150 tw__ease-in-out sm:tw__text-sm sm:tw__leading-5 @error('email') tw__border-red-300 tw__text-red-900 tw__placeholder-red-300 focus:tw__border-red-300 focus:tw__ring-red @enderror" />
                    </div>

                    @error('email')
                        <p class="tw__mt-2 tw__text-sm tw__text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="password" class="tw__block tw__text-sm tw__font-medium tw__text-gray-700 tw__leading-5">
                        Password
                    </label>

                    <div class="tw__mt-1 tw__rounded-md tw__shadow-sm">
                        <input wire:model.defer="password" id="password" type="password" placeholder="Password" required class="tw__appearance-none tw__block tw__w-full tw__px-3 tw__py-2 tw__border tw__border-gray-300 tw__rounded-md tw__placeholder-gray-400 focus:tw__outline-none focus:tw__ring-blue focus:tw__border-blue-300 tw__transition tw__duration-150 tw__ease-in-out sm:tw__text-sm sm:tw__leading-5 @error('password') tw__border-red-300 tw__text-red-900 tw__placeholder-red-300 focus:tw__border-red-300 focus:tw__ring-red @enderror" />
                    </div>

                    @error('password')
                        <p class="tw__mt-2 tw__text-sm tw__text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="tw__flex tw__items-center tw__justify-between tw__mt-6">
                    <div class="tw__flex tw__items-center">
                        <input wire:model.defer="remember" id="remember" type="checkbox" class="tw__form-checkbox tw__w-4 tw__h-4 tw__text-indigo-600 tw__transition tw__duration-150 tw__ease-in-out" />
                        <label for="remember" class="tw__block tw__ml-2 tw__text-sm tw__text-gray-900 tw__leading-5">
                            Remember
                        </label>
                    </div>

                    <div class="tw__text-sm tw__leading-5">
                        <a href="{{ route('password.request') }}" class="tw__font-medium tw__text-indigo-600 hover:tw__text-indigo-500 focus:tw__outline-none focus:tw__underline tw__transition tw__ease-in-out tw__duration-150">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div class="tw__mt-6">
                    <span class="tw__block tw__w-full tw__rounded-md tw__shadow-sm">
                        <button type="submit" class="tw__flex tw__justify-center tw__w-full tw__px-4 tw__py-2 tw__text-sm tw__font-medium tw__text-white tw__bg-indigo-600 tw__border tw__border-transparent tw__rounded-md hover:tw__tw__bg-indigo-500 focus:tw__outline-none focus:tw__border-indigo-700 focus:tw__ring-indigo active:tw__bg-indigo-700 tw__transition tw__duration-150 tw__ease-in-out">
                            Sign in
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
