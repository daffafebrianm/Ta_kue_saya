<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function show($slug)
    {
        // Ambil kategori berdasarkan slug
        $kategori = Kategori::where('slug', $slug)->firstOrFail();

        // Ambil produk berdasarkan kategori
        $produks = $kategori->produk()->get();

        return view('category.show', compact('kategori', 'produks'));
    }
}
