<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProductKatalogController extends Controller
{
    public function index(Request $request)
    {
        // Menangkap kategori dari parameter URL
        $category = $request->input('category'); // Perbaikan: 'category' harus sesuai dengan query string di URL

        // Jika kategori dipilih, filter produk berdasarkan kategori
        if ($category) {
            // Filter produk berdasarkan kategori yang dipilih
            $produks = Produk::where('id_kategori', $category)->with('kategori')->paginate(10);
        } else {
            // Jika tidak ada kategori yang dipilih, tampilkan semua produk
            $produks = Produk::with('kategori')->paginate(10);
        }

        // Mengembalikan view dengan data produk
        return view('user.produk.produk', compact('produks'));
    }
}
