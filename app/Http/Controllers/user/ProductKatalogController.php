<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProductKatalogController extends Controller
{
    public function index(Request $request)
    {
        // Mapping kategori: key = nama kategori, value = tampil di tombol
        $categories = [
            ''          => 'Semua',
            'Cookies'   => 'Cookies',
            'Cakes'     => 'Cakes',
            'Dry Cake'  => 'Dry Cake',
        ];

        // Ambil kategori dari parameter URL
        $selectedCategory = $request->input('category', '');

        // Validasi kategori
        if ($selectedCategory !== '' && !array_key_exists($selectedCategory, $categories)) {
            return redirect()->route('produk.index')->with('error', 'Kategori tidak valid.');
        }

        // Query produk aktif & tersedia
        $produksQuery = Produk::with('kategori')
            ->where('status', 'aktif') // hanya produk aktif
            ->where('stok', '>', 0)    // hanya yang masih ada stok
            ->orderBy('created_at', 'desc'); // urutkan dari terbaru

        // Filter kategori jika dipilih
        if ($selectedCategory !== '') {
            $produksQuery->whereHas('kategori', function ($q) use ($selectedCategory) {
                $q->where('nama', $selectedCategory);
            });
        }

        // Pagination (8 produk per halaman)
        $produks = $produksQuery->paginate(8)->withQueryString();

        return view('user.produk.produk', [
            'produks' => $produks,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}
