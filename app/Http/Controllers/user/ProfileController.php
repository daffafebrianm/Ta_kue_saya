<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
        public function index()
    {
          $user = Auth::user(); // cuma data user yang login
        return view('user.profile.index', compact('user'));
    }

     public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama'         => ['required','string','max:100'],
            'username'     => [
                'required','string','max:100',
                Rule::unique('users','username')->ignore($user->id),
            ],
            'email'        => [
                'required','email','max:150',
                Rule::unique('users','email')->ignore($user->id),
            ],
            'phone_number' => ['nullable','string','max:20'],
            'password'     => ['nullable','string','min:8','confirmed'], // gunakan field password_confirmation
        ]);

        // Jika password diisi, hash; kalau kosong, jangan sentuh kolomnya
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
