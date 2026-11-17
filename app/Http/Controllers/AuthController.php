<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $cred = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 'aktif' => true: akun yang dinonaktifkan tidak bisa masuk
        if (Auth::attempt($cred + ['aktif' => true], $request->boolean('remember'))) {
            $request->session()->regenerate();
            session(['jenis' => Auth::user()->jenis_default ?? 'konsumen']);

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah, atau akun tidak aktif.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}