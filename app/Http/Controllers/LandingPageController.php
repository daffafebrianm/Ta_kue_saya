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
        // Produk aktif terbaru (untuk katalog / section lain)
        $produks = Produk::aktif()->latest()->take(6)->get();


        // Kategori (jika dipakai di bagian lain)
        $kategoris = Kategori::all();

        // Jumlah cart
        $cartCount = auth()->check()
            ? Keranjang::where('user_id', auth()->id())->count()
            : 0;

        return view('user.home', compact(
            'produks',
            'kategoris',
            'cartCount'
        ));
    }
}
