<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    // GET /customer/keranjang
    public function index()
    {
        $keranjangs = Keranjang::query()
            ->with(['produk:id,nama,harga,stok,status']) // sesuaikan kolom yang dipakai di view
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $subtotal = $keranjangs->getCollection()->sum(function ($k) {
            $harga = (float) ($k->produk->harga ?? 0);

            return $harga * (int) $k->jumlah;
        });

        return view('user.keranjang.index', compact('keranjangs', 'subtotal'));
    }

    // POST /customer/keranjang  (tambah item)
    public function addToCart(Request $request)
    {
        // 1) Harus login
        if (! Auth::check()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['ok' => false, 'message' => 'Silakan login dulu.'], 401);
            }

            return redirect()->route('login')->with('warning', 'Silakan login dulu.');
        }

        // 2) Validasi input
        $data = $request->validate([
            'produk_id' => ['required', 'exists:produks,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $userId = Auth::id();
        $produkId = (int) $data['produk_id'];
        $tambah = (int) $data['jumlah'];

        try {
            DB::transaction(function () use ($userId, $produkId, $tambah) {
                // Lock product & row keranjang
                $produk = Produk::lockForUpdate()->findOrFail($produkId);

                if ($produk->status !== 'aktif') {
                    abort(422, 'Produk tidak aktif.');
                }

                // Ambil/lock baris keranjang
                $row = Keranjang::lockForUpdate()->firstOrCreate(
                    ['user_id' => $userId, 'produk_id' => $produkId],
                    ['jumlah' => 0]
                );

                // total baru yang diinginkan
                $totalBaru = $row->jumlah + $tambah;

                // Jika stok dikelola, validasi terhadap total
                if (! is_null($produk->stok) && $produk->stok < $totalBaru) {
                    abort(422, 'Stok tidak mencukupi.');
                }

                // Simpan
                $row->jumlah = $totalBaru;
                $row->save();
            });

            // 3) Hitung total item untuk badge (opsional)
            $cartCount = Keranjang::where('user_id', $userId)->sum('jumlah');

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'ok' => true,
                    'message' => 'Produk berhasil ditambahkan ke keranjang.',
                    'cart_count' => (int) $cartCount,
                ]);
            }

            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');

        } catch (\Throwable $e) {
            $msg = $e->getMessage() ?: 'Terjadi kesalahan.';
            if ($request->expectsJson() || $request->ajax()) {
                $code = $e->getCode();
                $http = in_array($code, [401, 403, 404, 422]) ? $code : 422;

                return response()->json(['ok' => false, 'message' => $msg], $http);
            }

            return back()->with('error', $msg);
        }
    }

    // PATCH /customer/keranjang/{id} (update qty)
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $row = Keranjang::with('produk')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Validasi stok & status produk saat update
        if ($row->produk) {
            if ($row->produk->status !== 'aktif') {
                return back()->with('error', 'Produk tidak aktif.');
            }
            if ($row->produk->stok !== null && $row->produk->stok < $data['jumlah']) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
        }

        $row->update(['jumlah' => (int) $data['jumlah']]);

        return back()->with('success', 'Kuantitas diperbarui.');
    }

    // DELETE /customer/keranjang/{id} (hapus item)
    public function destroy($id)
    {
        $row = Keranjang::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $row->delete();

        return redirect()->route('keranjang.index')
            ->with('success', 'Item dihapus dari keranjang.');
    }

    // DELETE /customer/keranjang (kosongkan keranjang)
    public function clear()
    {
        Keranjang::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
