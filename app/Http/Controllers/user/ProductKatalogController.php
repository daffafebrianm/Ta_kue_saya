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
        $category = $request->input('category');
        if ($category && ! in_array($category, ['6', '7', '8'])) {
            return redirect()->route('produk.index')->with('error', 'Kategori tidak valid.');
        }

        if ($category) {
            $produks = Produk::where('id_kategori', $category)->with('kategori')->paginate(10);
        } else {
            $produks = Produk::with('kategori')->paginate(10);
        }

        // Mengembalikan view dengan data produk
        return view('user.produk.produk', compact('produks', 'category'));
    }
}
