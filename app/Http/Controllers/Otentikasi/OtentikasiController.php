<?php

namespace App\Http\Controllers\Otentikasi;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OtentikasiController extends Controller
{
    // public function index()
    // {
    //     return view('otentikasi.login');
    // }
    // buat di route web Route::get('/', 'Otentikasi\OtentikasiController@index')->name('login');
    // dan buat di folder view otentikasi/login.blade.php
    
    public function login(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email'=>'required|email|exists:users',
            'password' => 'required',
          ]);
        $data = User::whereEmail($request->email)->firstOrFail();
        if ($data) {
            if (Hash::check($request->password,$data->password)) {
                return redirect('/admin');
            }else{
                return back()->with('error', 'passwords do not match');
            }
        }
        return back()->with('error', 'email / password salah');
        // return redirect('/')->with('message', 'Password  atau Email tidak cocok');
    }

}
