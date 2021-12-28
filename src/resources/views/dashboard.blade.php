@extends('LaravelMobileAuth::layouts.master')

@section('title', 'داشبورد کاربر')

@section('content')
    <x-LaravelMobileAuth::logo/>

    <section class="mt-4 bg-white rounded-lg shadow-sm p-8 w-1/4">

        <!-- Cart Header -->
        <div>
            <h1 class="dana-600 text-blue-500 font-bold text-xl text-center">
                داشبورد کاربر
            </h1>

            <p class="mt-2 text-gray-500 dana-400 text-sm text-center">
                به حساب کاربریتان خوش آمدید!
            </p>
        </div>

        <!-- Cart Body -->
        <div class="mt-4">

            @if(Session::has('welcome_message'))
                <div class="mb-2 bg-green-50 dana-400 text-green-500 rounded px-4 py-2">
                    ورود شما موفقیت آمیز بود!
                </div>
            @endif


            <div class="flex items-center">
                <h1 class="dana-400 text-gray-600">
                    شماره موبایل:
                </h1>
                <p class="dana-400 text-rose-500 mr-2">
                    {{ auth()->user()->phone }}
                </p>
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('laravel_mobile_auth.logout') }}" class="bg-rose-500 text-white text-center text-sm dana-400 px-2 py-2 rounded w-2/6">
                    خروج از حساب
                </a>
            </div>
        </div>


    </section>
@endsection
