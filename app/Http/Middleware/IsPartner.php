<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsPartner
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
        if (Auth::user() && Auth::user()->roles == "PARTNER") {
            //Auth::user() : mengecek apakah login/tidak
            //Auth::user()->roles == "ADMIN" : apakah rolesnya admin /tidak
            return $next($request);
            //melanjutkan request yg sebelumnya
        }
        elseif (Auth::user() && Auth::user()->roles == "ADMIN" ) {
            //Auth::user() : mengecek apakah login/tidak
            //Auth::user()->roles == "ADMIN" : apakah rolesnya admin /tidak
            return redirect('/admin');
            //melanjutkan request yg sebelumnya
        }

        if(\Request::segment(1) == 'api') {
            return response([
                'status' => 'error',
                'message' => 'Salah Roles',
                'role' => $user
            ], 400);
        }

        // return redirect('/');
        //jika tidakx retunr (' / ')
    }
}
