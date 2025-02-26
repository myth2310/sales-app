<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('Login.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['username' => 'Username atau password salah'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

}
