<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MyaccountController extends Controller
{
    public function login_check(Request $request){

        $credentials = $request->validate([
            'username' => ['required', 'email'],
            'user_password' => ['required'],
        ]);

        $remember_me = $request->has('remember') ? true : false;

        $rem_data = [
            'username' => $request->username,
            'user_password' => $request->user_password,
        ];

        if($remember_me){
            Session::put('remember_me', $rem_data);
        }else{
            Session::put('remember_me', []);
        }

        $authenticated = Auth::attempt([
            'email' => $request->username,
            'password' => $request->user_password,
            'status' => function ($query) {
                $query->where('status', '1');
            }

        ]);

        if ($authenticated) {
            $request->session()->regenerate();
            Session::put('user_session', Auth::user());

            return response()->json([
                'status' => 1,
                'msg' => 'login success',
                'redrict' => 'default',
                'user_type' => Auth::user()->is_admin == 1 ? 'admin' : 'user',
            ]);
                
        }

        return response()->json([
            'status' => 0,
            'msg' => 'The provided credentials do not match our records.',
        ]);

    }

    public function user_emailCheck(Request $request){
        $user = User::where('email', $request->email)->count();
        if($user==0){
            return false;
        }else{
            return true;
        }
    }

    public function user_logout(){
        Auth::logout();
        Session::forget('user_session');
        return redirect('/');
    }

    /**
     * Send a one-time password (OTP) to the user's email for login.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'username' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->username)
                    ->where('status', '1')
                    ->first();

        if (! $user) {
            return response()->json([
                'status' => 0,
                'msg' => 'No active user found with that email.',
            ]);
        }

        // generate six digit code
        $otp = rand(100000, 999999);

        // store otp and 5‑minute expiry
        $request->session()->put('login_otp', [
            'code'     => $otp,
            'email'    => $user->email,
            'expires'  => now()->addMinutes(5),
        ]);

        // send OTP via email (assumes mail is configured)
        Mail::raw("Your login OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your OTP Code');
        });

        return response()->json([
            'status' => 1,
            'msg'    => 'OTP has been sent to your email.',
            'step'   => 'otp',
        ]);
    }

    /**
     * Verify the OTP entered by the user and log them in.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required'],
        ]);

        $otpData = $request->session()->get('login_otp');

        if (! $otpData || now()->gt($otpData['expires']) || $otpData['code'] != $request->otp) {
            return response()->json([
                'status' => 0,
                'msg'    => 'The provided OTP is invalid or has expired.',
            ]);
        }

        $user = User::where('email', $otpData['email'])->first();
        if (! $user) {
            return response()->json([
                'status' => 0,
                'msg'    => 'User record not found.',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();
        Session::put('user_session', Auth::user());
        $request->session()->forget('login_otp');

        return response()->json([
            'status' => 1,
            'msg' => 'login success',
            'redrict' => 'default',
            'user_type' => Auth::user()->is_admin == 1 ? 'admin' : 'user',
        ]);
    }
}
