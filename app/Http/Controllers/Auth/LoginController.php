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
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.index');
            }
            if ($user->role === 'member') {
                return redirect()->route('member.index');
            }
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
            $user = Auth::user();

            // Redirect Berdasarkan Role
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.index'));
            }

            if ($user->role === 'member') {
                return redirect()->intended(route('member.index'));
            }

            // Jika tidak ada Role yang sesuai
            return redirect('/');
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