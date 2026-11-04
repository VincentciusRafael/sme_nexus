<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Satu view dipakai untuk /login dan /register.
    public function show()
    {
        return view('auth.auth');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Admin langsung ke halaman admin, user lain tetap ke dashboard.
            $user = Auth::user();
            $default = $user && $user->role === 'admin' ? '/admin/business-autopsy' : '/dashboard';

            return redirect()->intended($default);
        }

        // 'form' ikut dikirim balik agar halaman tetap membuka panel login.
        return back()
            ->withErrors(['email' => 'Email atau kata sandi salah.'])
            ->onlyInput('email', 'form');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms'    => ['accepted'],
        ], [
            'email.unique'       => 'Email ini sudah terdaftar. Silakan masuk.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sama.',
            'password.min'       => 'Kata sandi minimal 8 karakter.',
            'terms.accepted'     => 'Setujui syarat dan ketentuan untuk melanjutkan.',
        ]);

        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'sme_owner',
            'is_verified' => false,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
