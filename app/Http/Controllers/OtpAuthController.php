<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Otp;

class OtpAuthController extends Controller
{
    // Send OTP to email and store in DB
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)
                    ->where('status', '1')
                    ->first();

        if (! $user) {
            return response()->json([
                'status' => 0,
                'msg' => 'No active user found with that email.',
            ]);
        }

        $otp = rand(100000, 999999);
        $expires = now()->addMinutes(5);

        Otp::create([
            'email' => $user->email,
            'code' => $otp,
            'expires_at' => $expires,
            'used' => false,
        ]);

        Mail::raw("Your login OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your OTP Code');
        });

        return response()->json([
            'status' => 1,
            'msg' => 'OTP has been sent to your email.',
            'step' => 'otp',
        ]);
    }

    // Verify OTP and login
    // public function verifyOtp(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'otp' => 'required|numeric',
    //     ]);

    //     $otpData = Otp::where('email', $request->email)
    //         ->where('code', $request->otp)
    //         ->where('used', false)
    //         ->where('expires_at', '>', now())
    //         ->first();

    //     if (! $otpData) {
    //         return response()->json([
    //             'status' => 0,
    //             'msg' => 'The provided OTP is invalid or has expired.',
    //         ]);
    //     }

    //     $user = User::where('email', $request->email)
    //                 ->where('status', '1')
    //                 ->first();
    //     if (! $user) {
    //         return response()->json([
    //             'status' => 0,
    //             'msg' => 'User record not found.',
    //         ]);
    //     }

    //     Auth::login($user);
    //     $otpData->used = true;
    //     $otpData->save();

    //     return response()->json([
    //         'status' => 1,
    //         'msg' => 'login success',
    //         'user_type' => Auth::user()->is_admin == 1 ? 'admin' : 'user',
    //         'user_details' => Auth::user(),
    //     ]);
    // }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        $otpData = Otp::where('email', $request->email)
            ->where('code', $request->otp)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (! $otpData) {
            return response()->json([
                'status' => 0,
                'msg' => 'The provided OTP is invalid or has expired.',
            ]);
        }

        $user = User::where('email', $request->email)
            ->where('status', '1')
            ->first();

        if (! $user) {
            return response()->json([
                'status' => 0,
                'msg' => 'User record not found.',
            ]);
        }

        // ✅ Mark OTP used
        $otpData->used = true;
        $otpData->save();

        // ✅ Create Token
        $token = $user->createToken('auth_token')->plainTextToken;

        LoginHistory::create([
            'user_id' => $user->id,
            'login_time' => now(),
            'token' => $token,
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'status' => 1,
            'msg' => 'Login success',
            'user_type' => $user->is_admin == 1 ? 'admin' : 'user',
            'token' => $token, // ✅ TOKEN RETURN
            'user_details' => $user,
        ]);
    }
}
