<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function index()
    {

        return view('menu/login/index')->with([
            'user' => Auth::user()
        ]);
    }

    function login(Request $request)
    {
        Session::flash('email', $request->input('email'));

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $infologin = [
            'username' => $request->username,
            'password' => $request->password
        ];
        if (Auth::attempt($infologin)) {
            return redirect('dashboard')->with('success', 'Berhasil login')->with([
                'user' => Auth::user()
            ]);;
            // echo 'SUKSES';
        } else {
            // echo 'GAGAL';
            return redirect('auth')->withErrors('Username dan password yang dimasukkan tidak sesuai');
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Berhasil logout');
    }
}
