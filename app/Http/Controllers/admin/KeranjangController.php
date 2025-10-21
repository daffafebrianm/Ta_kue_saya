<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // Tampilkan semua keranjang
    public function index()
    {
        $keranjangs = Keranjang::with('user','produk')->paginate(10);
        return view('admin.keranjang.index', compact('keranjangs'));
    }

    // Tambah keranjang
    public function create()
    {
        $users = User::all();
        $produks = Produk::all();
        return view('admin.keranjang.create', compact('users', 'produks'));
    }

    // Simpan keranjang
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        Keranjang::create($request->all());
        return redirect()->route('admin.keranjang.index')->with('success','Keranjang berhasil ditambahkan');
    }

    // Hapus keranjang
    public function destroy($id)
    {
        $keranjang = Keranjang::findOrFail($id);
        $keranjang->delete();
        return redirect()->route('admin.keranjang.index')->with('success','Keranjang berhasil dihapus');
    }

public function addToCart(Request $request)
{
    $request->validate([
        'produk_id' => 'required|exists:produks,id',
        'jumlah' => 'required|integer|min:1',
    ]);

    $userId = Auth::id(); // user yang sedang login
    $produkId = $request->produk_id;
    $jumlah = $request->jumlah;

    // cek apakah produk sudah ada di keranjang user
    $keranjang = Keranjang::where('user_id', $userId)
                        ->where('produk_id', $produkId)
                        ->first();

    if ($keranjang) {
        // jika sudah ada, update jumlah
        $keranjang->increment('jumlah', $jumlah);
    } else {
        // jika belum ada, buat baru
        Keranjang::create([
            'user_id' => $userId,
            'produk_id' => $produkId,
            'jumlah' => $jumlah,
        ]);
    }

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
}
}

