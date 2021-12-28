<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$_namespace = '\KaqazStudio\LaravelMobileAuth\Http\Controllers';

Route::namespace($_namespace)
    ->middleware('guest')
    ->group(function () {

    Route::get('login', 'AuthController@login')->name('laravel_mobile_auth.login');

    Route::get('password-login', 'AuthController@passwordLogin')->name('laravel_mobile_auth.password');

    Route::post('password-login', 'AuthController@passwordCheck')->name('laravel_mobile_auth.password.check');

    Route::get('otp-login', 'AuthController@otpLogin')->name('laravel_mobile_auth.otp');

    Route::post('otp-login', 'AuthController@otpCheck')->name('laravel_mobile_auth.otp.check');

    Route::post('auth', 'AuthController@checkAuth')->name('laravel_mobile_auth.auth');
});


Route::namespace($_namespace)
    ->middleware('auth')
    ->group(function () {
        Route::get('dashboard', 'AuthController@dashboard')->name('laravel_mobile_auth.dashboard');

        Route::get('logout', 'AuthController@logout')->name('laravel_mobile_auth.logout');
    });
