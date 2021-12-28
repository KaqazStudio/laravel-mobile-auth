@extends('LaravelMobileAuth::layouts.master')

@section('title', 'ورود به حساب کاربری')

@section('content')

    <x-LaravelMobileAuth::logo/>

    <section class="mt-4 bg-white rounded-lg shadow-sm p-8">

        <!-- Cart Header -->
        <div>
            <h1 class="dana-600 text-blue-500 font-bold text-xl text-center">
                ورود به حساب کاربری
            </h1>

            <p class="mt-2 text-gray-500 dana-400 text-sm text-center">
                برای ورود به حساب کاربری شماره موبایل خود را وارد نمایید.
            </p>
        </div>

        <!-- Cart Body -->
        <div class="mt-4">
            @if(Session::has('is_logged_out'))
                <div class="mb-2 bg-rose-50 dana-400 text-sm text-rose-500 rounded px-4 py-2">
                    خروج شما از حساب کاربری موفقیت آمیز بود!
                </div>
            @endif

            <form action="{{ route('laravel_mobile_auth.auth') }}" method="post" class="flex flex-col">
                @csrf

                <label for="phone">
                    <span class="text-sm text-gray-700 dana-400">
                        شماره موبایل
                    </span>
                    <span class="text-rose-500">
                        *
                    </span>
                </label>
                <input class="bg-slate-50 border border-slate-100 rounded px-2 py-2 dana-400 text-sm"
                       placeholder="09123002020"
                       dir="ltr"
                       type="tel"
                       name="phone"
                       id="phone"
                       value="{{ old('phone') }}">

                @error('phone')
                    <span class="text-sm text-rose-500 dana-400 mt-2">
                        {{ $message }}
                    </span>
                @enderror

                <div class="flex items-end justify-end">
                    <button class="mt-4 bg-blue-500 text-white text-sm dana-400 px-2 py-2 rounded w-3/6"
                            type="submit">
                        تایید شماره موبایل
                    </button>
                </div>

            </form>
        </div>


    </section>

@endsection
