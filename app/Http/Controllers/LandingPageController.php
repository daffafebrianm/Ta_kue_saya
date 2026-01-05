<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function admin()
    {
        return view('admin.Dashboard');
    }

    public function user()
    {
    $produks = Produk::aktif()->latest()->take(12)->get();

        // Ambil kategori produk
        $kategoris = Kategori::all(); // Ambil semua kategori, sesuaikan jika nama model berbeda
        $cartCount = Auth::check() ? Keranjang::where('user_id', Auth::id())->count() : 0;

        // Kirim produk dan kategori ke view
        return view('user.home', compact('produks', 'kategoris', 'cartCount'));
    }
}
