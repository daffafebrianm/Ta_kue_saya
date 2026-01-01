<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

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

        // Kirim produk dan kategori ke view
        return view('user.home', compact('produks', 'kategoris'));
    }
}
