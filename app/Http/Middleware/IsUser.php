<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if(Auth::user()->is_admin == 0){
    //         return $next($request);
    //     }
    //     return redirect()->back()->with('error',"You don't have user access.");
    // }

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (
            ($user->is_admin == 0 && $user->user_access == 1) ||
            $user->user_access == 2
        ) {
            return $next($request);
        }

        return redirect()->back()->with('error', "You don't have user access.");
    }
}
