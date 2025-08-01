<?php

namespace App\Http\Controllers\Keuangan\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('keuangan.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('keuangan')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('keuangan.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('keuangan')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('keuangan.login');
    }
}
