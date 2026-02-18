<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
}
