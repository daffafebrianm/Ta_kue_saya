<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
  // Controller
public function index($orderId)
    {
        // Ambil ID pengguna yang sedang login
        $userId = Auth::id();

        // Ambil pesanan berdasarkan order_id dan user yang login
        $order = Order::with('orderDetails.produk') // Pastikan orderDetails dan produk di-eager load
            ->where('user_id', $userId) // Pastikan pesanan milik pengguna yang login
            ->where('id', $orderId) // Filter berdasarkan order_id
            ->first(); // Ambil satu pesanan berdasarkan kriteria

        // Jika pesanan tidak ditemukan atau tidak milik user yang login
        if (!$order) {
            return redirect()->route('user.orders.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Setup Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;


    $orderDetail = $order->orderDetails->first(); // Asumsikan hanya satu produk per pesanan
        // Param pembayaran untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_code, // Gunakan order_code dari database
                'gross_amount' => $order->totalharga,
            ],
            'customer_details' => [
                'first_name' => $order->nama,
                'phone' => $order->phone_number,
                ''

            ],
        ];

        // Buat snap token untuk pembayaran
        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return redirect()->route('user.orders.index')->with('error', 'Terjadi kesalahan saat menghubungkan dengan Midtrans: ' . $e->getMessage());
        }

        // Kirim data pesanan dan snapToken ke view
        return view('user.pembayaran.index', compact('order', 'snapToken'));
    }
public function callback(Request $request)
{
    // Ambil server key dari konfigurasi
    $serverKey = config('midtrans.server_key');

    // Validasi signature key dari Midtrans
    $hashed = hash(
        "sha512",
        $request->order_id .
        $request->status_code .
        $request->gross_amount .
        $serverKey
    );

    // Periksa apakah signature key valid
    if ($hashed !== $request->signature_key) {
        return response()->json(['error' => 'Invalid signature'], 403);
    }

    // Cari pesanan berdasarkan order_id
    $pesanan = Order::where('order_code', $request->order_id)->first();

    // Pastikan pesanan ada
    if (!$pesanan) {
        return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
    }

    // Ambil status transaksi dan status fraud dari notifikasi
    $transaction = $request->transaction_status;
    $fraud = $request->fraud_status;

    // Proses berdasarkan status transaksi
    if ($transaction == 'capture' || $transaction == 'settlement') {
        // Jika transaksi berhasil dan tidak ada fraud
        if ($fraud == 'accept') {
            // Update status pembayaran dan pengiriman
            $pesanan->update([
                'payment_status' => 'paid',
                'shipping_status' => 'processing',
            ]);

            // Kurangi stok produk untuk setiap item yang dipesan
            foreach ($pesanan->orderDetails as $item) {
                if ($item->produk) {
                    $produk = $item->produk;
                    $stokProduk = $produk->stok;

                    // Pastikan stok cukup
                    if ($stokProduk >= $item->quantity) {
                        // Mengurangi stok dengan transaksi DB untuk memastikan konsistensi
                        DB::beginTransaction();
                        try {
                            $produk->update([
                                'stok' => $stokProduk - $item->quantity
                            ]);
                            DB::commit(); // Commit jika berhasil
                        } catch (\Exception $e) {
                            DB::rollBack(); // Rollback jika terjadi error
                            return response()->json(['error' => 'Gagal mengupdate stok produk'], 500);
                        }
                    } else {
                        return response()->json(['error' => 'Stok produk tidak cukup'], 400);
                    }
                }
            }
        }
    } elseif ($transaction == 'pending') {
        $pesanan->update([
            'payment_status' => 'pending',
            'shipping_status' => 'pending',
        ]);
    } else { // deny, expire, cancel
        $pesanan->update([
            'payment_status' => 'cancel',
            'shipping_status' => 'cancel',
        ]);
    }

    return response()->json(['success' => true]);
}




  // Method untuk menampilkan halaman sukses pembayaran
    public function success($orderId)
    {
        // Cari pesanan berdasarkan orderId
        $order = Order::find($orderId);

        // Pastikan pesanan ditemukan
        if (!$order) {
            return redirect()->route('user.order.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Kirim data pesanan ke view pembayaran.success
        return view('user.pembayaran.pembayaran-succes', compact('order'));
    }

}
