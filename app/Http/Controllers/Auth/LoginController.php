<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('Auth/Login');
    }

    /**
     * Proses autentikasi user.
     */
    public function authenticate(Request $request)
    {
        // Validasi input
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]); 

        // Cek input apakah email atau username
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Susun credentials secara dinamis
        $credentials = [
            $fieldType => $request->login,
            'password' => $request->password,
        ];

        // Login (menggunakan username & password)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // Redirect ke dashboard untuk semua user
            return redirect()->intended(route('dashboard'));
        }

        // Jika Gagal, kembali ke Vue
        throw ValidationException::withMessages([
            'loginError' => 'Credentials login tidak sesuai.',
        ]);
    }

    /**
     * Proses Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}