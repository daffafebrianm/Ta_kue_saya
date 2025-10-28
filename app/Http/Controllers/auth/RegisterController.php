<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'email', 'max:50', 'unique:users,email'],
            // 'phone_number' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:8'], // gunakan password_confirmation
        ]);

        // role default = customer (abaikan input role jika ada)
        $validated['role'] = 'customer';

        // password akan auto-hash karena cast 'hashed' di model
        $user = User::create($validated);

        // Login otomatis
        Auth::login($user);

        // Arahkan ke dashboard customer
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil!');
    }
}
