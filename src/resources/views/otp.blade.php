@extends('LaravelMobileAuth::layouts.master')

@section('title', 'ورود با رمز یکبار مصرف')

@section('content')
    <x-LaravelMobileAuth::logo/>

    <section class="mt-4 bg-white rounded-lg shadow-sm p-8 w-1/4">

        <!-- Cart Header -->
        <div>
            <h1 class="dana-600 text-blue-500 font-bold text-xl text-center">
                ورود با رمز یکبار مصرف
            </h1>

            <p class="mt-2 text-gray-500 dana-400 text-sm text-center">
                کد تایید ارسال شده به شماره زیر را وارد نمایید.
            </p>
        </div>

        <!-- Cart Body -->
        <div class="mt-4">
            <form action="{{ route('laravel_mobile_auth.otp.check') }}" method="post" class="flex flex-col">
                @csrf

                <label for="phone" class="flex items-center justify-between">
                    <div>
                        <span class="text-sm text-gray-700 dana-400">
                        شماره موبایل
                    </span>
                        <span class="text-rose-500">
                        *
                    </span>
                    </div>

                    <a href="{{ route('laravel_mobile_auth.login') }}" class="flex items-center group">
                        <span class="text-rose-500 text-sm dana-400 group-hover:text-rose-600">
                            ویرایش شماره
                        </span>
                        <svg class="stroke-rose-500 group-hover:stroke-rose-600 w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" width="18.482" height="18.482" viewBox="0 0 18.482 18.482">
                            <g id="Group_1" data-name="Group 1" transform="translate(-2 -2)">
                                <path id="Path_16" data-name="Path 16" d="M2.75,7.263V15.22c0,2.772,1.964,4.512,4.742,4.512h7.5c2.779,0,4.742-1.73,4.742-4.512V7.263c0-2.781-1.964-4.513-4.742-4.513h-7.5C4.714,2.75,2.75,4.481,2.75,7.263Z" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" fill-rule="evenodd" opacity="0.4"/>
                                <path id="Path_17" data-name="Path 17" d="M7.914,12h7.5" transform="translate(-0.424 -0.759)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                                <path id="Path_18" data-name="Path 18" d="M11.369,15.133l-3.455-3.44,3.455-3.441" transform="translate(-0.424 -0.451)" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                            </g>
                        </svg>
                    </a>
                </label>
                <input class="bg-slate-50 border bg-rose-500 border-slate-100 rounded px-2 py-2 dana-400 text-sm text-gray-700"
                       value="{{ Session::get('phone', old('phone')) }}"
                       placeholder="09123456789"
                       readonly
                       dir="ltr"
                       type="tel"
                       name="phone"
                       id="phone">
                @error('phone')
                <span class="text-sm text-rose-500 dana-400 mt-2">
                        {{ $message }}
                    </span>
                @enderror

                <label for="otp" class="mt-4">
                    <span class="text-sm text-gray-700 dana-400">
                        رمز یکبار مصرف
                    </span>
                    <span class="text-rose-500">
                        *
                    </span>
                </label>
                <input class="bg-slate-50 border border-slate-100 rounded px-2 py-2 dana-400 text-sm text-gray-700"
                       placeholder="*****"
                       value=""
                       dir="ltr"
                       type="tel"
                       name="otp"
                       id="otp">
                @error('otp')
                    <span class="text-sm text-rose-500 dana-400 mt-2">
                        {{ $message }}
                    </span>
                @enderror

                <div class="flex items-center justify-between mt-4">
                    @if(Session::get('can_login_with_password', false))
                        <a href="/password-login" class="text-blue-500 text-sm hover:text-blue-600">
                            ورود با گذرواژه
                        </a>
                    @else
                        <div>
                            &nbsp;
                        </div>
                    @endif

                    <button class="bg-blue-500 text-white text-sm dana-400 px-2 py-2 rounded w-3/6"
                            type="submit">
                        ورود به حساب من
                    </button>
                </div>

            </form>
        </div>


    </section>
@endsection
