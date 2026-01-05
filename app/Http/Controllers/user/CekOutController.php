<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Order;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CekOutController extends Controller
{
    public function index(Request $request)
    {
        $produkId = $request->query('produk_id');
        $jumlah = (int) $request->query('jumlah', 1);
        $jumlah = max(1, $jumlah);

        // Mode BUY NOW
        if ($produkId) {
            $produk = Produk::findOrFail($produkId);

            // Optional: guard stok
            if ($produk->stok < $jumlah) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi.');
            }

            // Bikin struktur mirip keranjang biar view kamu nggak perlu dirombak besar-besaran
            $keranjangs = collect([
                (object) [
                    'id' => null,
                    'user_id' => Auth::id(),
                    'produk_id' => $produk->id,
                    'jumlah' => $jumlah,
                    'produk' => $produk,
                    'is_buy_now' => true,
                ],
            ]);

            $subtotal = $produk->harga * $jumlah;

            // Flag biar view tahu ini BUY NOW
            $isBuyNow = true;

            return view('user.order.index', compact('keranjangs', 'subtotal', 'isBuyNow', 'produkId', 'jumlah'));
        }

        // Mode CART (default)
        $keranjangs = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong.');
        }

        $subtotal = $keranjangs->sum(function ($keranjang) {
            return $keranjang->produk->harga * $keranjang->jumlah;
        });

        $isBuyNow = false;
        $produkId = null;
        $jumlah = null;

        return view('user.order.index', compact('keranjangs', 'subtotal', 'isBuyNow', 'produkId', 'jumlah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'alamat' => 'required|string',
            'shipping_method' => 'required|in:picked up,delivered',
            // Untuk BUY NOW (opsional)
            'produk_id' => 'nullable|integer|exists:produks,id',
            'jumlah' => 'nullable|integer|min:1',
            'note' => 'nullable|string',
        ]);

        try {
            // Jalankan transaksi database
            $pesanan = DB::transaction(function () use ($request) {
                $order_code = $this->generateOdrId();
                $produkId = $request->input('produk_id');
                $jumlah = max(1, (int) $request->input('jumlah', 1));

                // 🔹 1. Tentukan sumber item (BUY NOW / CART)
                if ($produkId) {
                    // Mode BUY NOW
                    $produk = Produk::lockForUpdate()->findOrFail($produkId);

                    if ($produk->stok < $jumlah) {
                        throw new \Exception('Stok tidak mencukupi.');
                    }

                    $items = collect([[
                        'produk_id' => $produk->id,
                        'jumlah' => $jumlah,
                        'harga' => $produk->harga,
                        'total' => $produk->harga * $jumlah,
                        'produk' => $produk,
                    ]]);
                } else {
                    // Mode CART
                    $keranjangs = Keranjang::with('produk')
                        ->where('user_id', Auth::id())
                        ->lockForUpdate()
                        ->get();

                    if ($keranjangs->isEmpty()) {
                        throw new \Exception('Keranjang kosong.');
                    }

                    $items = $keranjangs->map(function ($k) {
                        return [
                            'produk_id' => $k->produk_id,
                            'jumlah' => $k->jumlah,
                            'harga' => $k->produk->harga,
                            'total' => $k->produk->harga * $k->jumlah,
                            'produk' => $k->produk,
                        ];
                    });
                }

                $totalharga = $items->sum('total');

                // 🔹 2. Simpan data pesanan utama
                $pesanan = new Order();
                $pesanan->user_id = Auth::id();
                $pesanan->order_code = $order_code;
                $pesanan->nama = $request->nama;
                $pesanan->phone_number = $request->phone_number;
                $pesanan->alamat = $request->alamat;
                $pesanan->shipping_method = $request->shipping_method;
                $pesanan->totalharga = $totalharga;
                $pesanan->payment_status = 'pending';
                $pesanan->shipping_status = 'pending';
                $pesanan->note = $request->note;
                $pesanan->order_date = Carbon::now()->toDateString();
                $pesanan->save();

                // Pastikan ID pesanan terbaca
                $pesanan->refresh();

                // 🔹 3. Simpan detail pesanan
                foreach ($items as $it) {
                    $harga_modal = DB::table('barang_masuks')
                        ->where('id_produk', $it['produk_id'])
                        ->orderByDesc('tanggal_masuk')
                        ->value('harga_modal') ?? 0;

                    $laba = ($it['harga'] - $harga_modal) * $it['jumlah'];

                    $pesanan->orderDetails()->create([
                        'produk_id' => $it['produk_id'],
                        'jumlah' => $it['jumlah'],
                        'harga' => $it['harga'],
                        'harga_modal' => $harga_modal,
                        'total' => $it['total'],
                        'laba' => $laba,
                    ]);
                }

                // 🔹 4. Hapus keranjang (kalau bukan BUY NOW)
                if (!$produkId) {
                    Keranjang::where('user_id', Auth::id())->delete();
                }

                // Return objek pesanan agar bisa digunakan di luar transaksi
                return $pesanan;
            });

            // 🔹 5. Redirect setelah transaksi sukses
            return redirect()
                ->route('Pembayaran.index', ['orderId' => $pesanan->id])
                ->with('success', 'Pesanan berhasil diproses.');
        } catch (\Exception $e) {
            // Jika error, rollback otomatis (karena DB::transaction)
            return redirect()
                ->back()
                ->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }




    private function generateOdrId()
    {
        $tanggal = date('dmY');

        $id = Order::selectRaw('RIGHT(order_code, 3) as id')
            ->whereDate('order_date', Carbon::today())
            ->orderByRaw('RIGHT(order_code, 3) DESC')
            ->lockForUpdate()
            ->limit(1)
            ->value('id');

        if ($id) {
            $id++;
            $no = str_pad($id, 3, '0', STR_PAD_LEFT);
            $new_id = 'ODR-' . $tanggal . $no;

            while (Order::where('order_code', $new_id)->exists()) {
                $id++;
                $no = str_pad($id, 3, '0', STR_PAD_LEFT);
                $new_id = 'ODR-' . $tanggal . $no;
            }

            return $new_id;
        }

        return 'ODR-' . $tanggal . '001';
    }
}
