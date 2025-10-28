<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginRaw = $credentials['login'];
        $login = trim($loginRaw);
        $password = $credentials['password'];
        $remember = $request->boolean('remember');

        $isEmail = filter_var($login, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {
            // Cari user dengan email yang sudah di-TRIM & LOWER langsung di SQL
            $user = User::whereRaw('LOWER(TRIM(email)) = ?', [Str::lower($login)])->first();

            if ($user && Hash::check($password, $user->password)) {
                Auth::login($user, $remember);
                $request->session()->regenerate();

                return $user->role === 'admin'
                    ? redirect()->route('dashboard')
                    : redirect()->route('landing');
            }
        } else {
            // Username tetap pakai attempt biasa
            if (Auth::attempt(['username' => $login, 'password' => $password], $remember)) {
                $request->session()->regenerate();

                return Auth::user()->role === 'admin'
                    ? redirect()->route('dashboard')
                    : redirect()->route('landing');
            }
        }

        return back()->withErrors([
            'login' => 'Kredensial tidak cocok.',
        ])->onlyInput('login');
    }

    // Logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
