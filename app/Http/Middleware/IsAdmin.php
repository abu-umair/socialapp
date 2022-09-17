<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //tambahin Auth, apakah auth admin / auth users
        $user = Auth::user()->roles;
        if (Auth::user() && Auth::user()->roles == "ADMIN") {
            //Auth::user() : mengecek apakah login/tidak
            //Auth::user()->roles == "ADMIN" : apakah rolesnya admin /tidak
            return $next($request);
            //melanjutkan request yg sebelumnya
        }
        // elseif (Auth::user() && Auth::user()->roles == "PARTNER" ) {
        //     return redirect('/partner');
        //     //melanjutkan request yg sebelumnya
        // }
        // else { //request Roles = USER
        //     Auth::logout();
        //     Session::flush();
        //     return redirect('/');
        // }

        return redirect('/');
        //jika tidakx retunr (' / ')
    }
}
