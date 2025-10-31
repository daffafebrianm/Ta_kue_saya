<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekOutController extends Controller
{
    public function index()
    {
        // Mengambil data keranjang milik pengguna yang sedang login
        $keranjangs = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get(); // Mengambil semua item dalam keranjang

        // Menghitung subtotal
        $subtotal = $keranjangs->sum(function ($keranjang) {
            return $keranjang->produk->harga * $keranjang->jumlah;
        });

        // Menampilkan halaman checkout dengan data keranjang dan subtotal
        return view('user.order.index', compact('keranjangs', 'subtotal'));
    }

    public function store(Request $request)
    {
        // Validasi input pengguna
        $request->validate([
            'nama' => 'required|string|max:255',
            'phone_number' => 'required|numeric', // Memastikan nomor telepon valid
            'alamat' => 'required|string',
           'shipping_method' => 'required|in:picked up,delivered',
        ]);

        // Membuat kode pesanan unik
        $order_code = $this->generateOdrId();

        // Mengambil data keranjang milik pengguna yang sedang login
        $keranjangs = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get(); // Mengambil semua item dalam keranjang

        // Menghitung total harga pesanan
        $totalharga = $keranjangs->sum(function ($keranjang) {
            return $keranjang->produk->harga * $keranjang->jumlah;
        });

        // Membuat data pesanan baru
        $pesanan = new Order();
        $pesanan->user_id = Auth::id();  // Menyimpan user_id
        $pesanan->order_code = $order_code; // Menyimpan kode pesanan unik
        $pesanan->nama = $request->nama; // Nama pengguna yang memasukkan data
        $pesanan->phone_number = $request->phone_number; // Nomor telepon dari form
        $pesanan->alamat = $request->alamat; // Alamat pengiriman dari form
        $pesanan->shipping_method = $request->shipping_method; // Metode pengiriman
        $pesanan->totalharga = $totalharga; // Total harga
        $pesanan->payment_status = 'pending'; // Status awal pembayaran
        $pesanan->shipping_status = 'pending'; // Status awal pengiriman
        $pesanan->note = $request->note; // Status awal pengiriman
        $pesanan->order_date = Carbon::now()->toDateString(); // Tanggal pesanan
        $pesanan->save();


        // Menyimpan item keranjang ke dalam pesanan
        foreach ($keranjangs as $keranjang) {
    try {
        $pesanan->orderDetails()->create([
            'produk_id' => $keranjang->produk_id,
            'jumlah' => $keranjang->jumlah,
            'harga' => $keranjang->produk->harga,
            'total' => $keranjang->produk->harga * $keranjang->jumlah,
        ]);
    } catch (\Exception $e) {
        dd($e->getMessage()); // Menangkap dan menampilkan error
    }
}


        // Menghapus item keranjang setelah checkout
        Keranjang::where('user_id', Auth::id())->delete();

        // Redirect atau kembali ke halaman lain dengan pesan sukses
        return redirect()->route('Pembayaran.index', ['orderId' => $pesanan->id])->with('success', 'Pesanan berhasil diproses');

    }

    private function generateOdrId()
    {
        $tanggal = date("dmY");

        // Ambil nomor urut terakhir untuk hari ini
        $id = Order::selectRaw('RIGHT(order_code, 3) as id')
            ->whereDate('order_date', Carbon::today())
            ->orderByRaw('RIGHT(order_code, 3) DESC')
            ->lockForUpdate()
            ->limit(1)
            ->value('id');

        if ($id) {
            // Increment nomor urut
            $id++;

            // Format nomor urut dengan 3 digit
            $no = str_pad($id, 3, '0', STR_PAD_LEFT);

            // Generate order_code baru
            $new_id = "ODR-" . $tanggal . $no;

            // Periksa apakah order_code sudah ada
            while (Order::where('order_code', $new_id)->exists()) {
                $id++;  // Increment lagi jika order_code sudah ada
                $no = str_pad($id, 3, '0', STR_PAD_LEFT);
                $new_id = "ODR-" . $tanggal . $no;
            }

            return $new_id;
        } else {
            // Jika tidak ada transaksi pada hari ini, mulai dari 001
            return "ODR-" . $tanggal . "001";
        }
    }
}
