<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class DetailProdukController extends Controller
{
     public function index($id)
    {
        // Ambil produk berdasarkan ID
        $product = Produk::with('kategori')->findOrFail($id);

        // Tampilkan halaman detail produk
        return view('user.produk.detail', compact('product'));
    }
}
