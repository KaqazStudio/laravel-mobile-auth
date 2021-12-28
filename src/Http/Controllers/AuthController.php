<?php

namespace KaqazStudio\LaravelMobileAuth\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use KaqazStudio\LaravelMobileAuth\Http\Models\Otp;
use Redirect;
use Auth;
use Hash;
use Session;

class AuthController extends BaseController
{
    public function login()
    {
        return view('LaravelMobileAuth::login');
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('laravel_mobile_auth.login')->with([
            'is_logged_out' => true
        ]);
    }

    public function otpLogin()
    {
        $phone = Session::get('phone');

        if (!$phone)
            return Redirect::route('laravel_mobile_auth.login');

        $this->_fireOtpEvent();

        Session::reflash();
        return view('LaravelMobileAuth::otp');
    }

    private function _fireOtpEvent()
    {
        $phone = Session::get('phone');

        $otpRequest = Otp::where('phone', $phone)->first();

        if (!$otpRequest) {
            $this->_generateOtp();
        } else {
            //100% Sure, otp exist!
            $expired_at = $otpRequest->created_at + 120;

            if (time() > $expired_at)
                $this->_generateOtp();
        }

    }

    private function _generateOtp()
    {
        $phone = Session::get('phone');

        Otp::where('phone', $phone)->delete();

        $code = random_int(1000, 9999);

        $isExist = Otp::where('code', $code)->first();

        if ($isExist)
            $this->_generateOtp();

        Otp::create([
            'phone' => $phone,
            'code'  => $code
        ]);
    }

    public function otpCheck(Request $request)
    {
        Session::reflash();
        $request->validate([
            'phone' => 'required|numeric|digits:11|exists:otps,phone',
            'otp'   => 'required|numeric|digits:4'
        ], [
            'phone.required' => 'شماره موبایل الزامی است',
            'phone.numeric'  => 'شماره موبایل باید عدد باشد.',
            'phone.digits'   => 'شماره موبایل باید 11 رقم باشد.',
            'phone.exists'   => 'شماره وارد شده معتبر نیست!',
            'otp.required'   => 'کدیکبار مصرف الزامی است',
            'otp.numeric'    => 'کدیکبار مصرف باید عدد باشد.',
            'otp.digits'     => 'کدیکبار مصرف باید 4 رقم باشد.',
        ]);

        // Validated
        $phone = $request->input('phone');
        $otp   = $request->input('otp');

        $otpRequest = Otp::where('phone', $phone)->first();

        if ($otpRequest->code != $otp)
            return Redirect::back()
                           ->withInput([
                               'phone' => $phone
                           ])
                           ->withErrors([
                               'otp' => 'رمز یکبار مصرف وارد شده معتبر نیست!'
                           ]);

        // 100% Sure, Code true!
        // Is Registered?
        $user = User::where('phone', $phone)->first();

        if (!$user)
        {
            User::create([ 'phone' => $phone ]);
            $user = User::where('phone', $phone)->first();
            Auth::loginUsingId($user->id);
        }

        Auth::loginUsingId($user->id);

        Otp::where('phone', $phone)->delete();
        User::where('phone', $phone)->update([
            'attempts_left'       => 3,
            'most_login_with_otp' => false
        ]);

        return Redirect::route('laravel_mobile_auth.dashboard')->with([
            'welcome_message' => true,
        ]);

    }

    public function dashboard()
    {
        return view('LaravelMobileAuth::dashboard');
    }

    public function passwordLogin()
    {
        return view('LaravelMobileAuth::password');
    }

    public function passwordCheck(Request $request)
    {
        $request->validate([
            'phone'    => 'required|numeric|digits:11|exists:users,phone',
            'password' => 'required'
        ], [
            'phone.required'    => 'شماره موبایل الزامی است',
            'phone.numeric'     => 'شماره موبایل باید عدد باشد.',
            'phone.digits'      => 'شماره موبایل باید 11 رقم باشد.',
            'phone.exists'      => 'شماره وارد شده معتبر نیست!',
            'password.required' => 'گذرواژه الزامی است.'
        ]);

        // Validated
        $phone = $request->input('phone');
        $password = $request->input('password');

        $user = User::where('phone', $phone)->first();

        if ($user->attempts_left <= 0 || $user->most_login_otp)
            return Redirect::route('laravel_mobile_auth.otp')->with([
                'phone'                             => $phone,
                'is_redirected_from_password_login' => true
            ]);


        if (Hash::check($password, $user->password)) {
            Auth::loginUsingId($user->id);
            $user->update([
                'attempts_left'       => 3,
                'most_login_with_otp' => false
            ]);
            return Redirect::route('laravel_mobile_auth.dashboard')->with([
                'welcome_message' => true,
            ]);
        }

        //100% Sure, password is wrong!
        $user->decrement('attempts_left', 1);

        return Redirect::back()
                       ->withInput(['phone' => $phone])
                       ->withErrors(['password' => 'گذرواژه شما اشتباه است!']);
    }

    public function checkAuth(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits:11'
        ], [
            'phone.required' => 'شماره موبایل الزامی است',
            'phone.numeric'  => 'شماره موبایل باید عدد باشد.',
            'phone.digits'   => 'شماره موبایل باید 11 رقم باشد.'
        ]);

        $phone = $request->input('phone');
        $user = User::where('phone', $phone)->first();

        if (!$user)
            return Redirect::route('laravel_mobile_auth.otp')->with([
                'phone'                   => $phone,
                'can_login_with_password' => false
            ]);

        // User exists!

        // Check for user login via password permission!
        if (!$user->password || $user->most_login_with_otp || $user->attempts_left <= 0)
            return Redirect::route('laravel_mobile_auth.otp')->with([
                'phone' => $phone
            ]);

        //User has any password...
        if ($user->attempts_left > 0)
            return Redirect::route('laravel_mobile_auth.password')->with([
                'phone' => $phone
            ]);
    }
}
