<?php

namespace App\Http\Controllers\user;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            return redirect()->route('user.order.index')->with('error', 'Pesanan tidak ditemukan.');
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
            return redirect()->route('Pembayaran.index')->with('error', 'Terjadi kesalahan saat menghubungkan dengan Midtrans: ' . $e->getMessage());
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

        if ($hashed !== $request->signature_key) {
            Log::warning("Midtrans signature invalid for order {$request->order_id}");
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        // Ambil pesanan beserta orderDetails dan produk masing-masing
        $pesanan = Order::with('orderDetails.produk')
            ->where('order_code', $request->order_id)
            ->first();

        if (!$pesanan) {
            Log::warning("Pesanan tidak ditemukan: {$request->order_id}");
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }

        $transaction = $request->transaction_status;
        $fraud = $request->fraud_status;

        try {
            DB::beginTransaction();

            if (in_array($transaction, ['capture', 'settlement']) && $fraud == 'accept') {
                // Update status pesanan
                $pesanan->update([
                    'payment_status' => 'paid',
                    'shipping_status' => 'processing',
                ]);

                // Kurangi stok produk
                foreach ($pesanan->orderDetails as $item) {
                    $produk = $item->produk;

                    if (!$produk) {
                        Log::error("Produk ID {$item->product_id} tidak ditemukan");
                        throw new \Exception("Produk tidak ditemukan");
                    }

                    if ($produk->stok < $item->jumlah) {
                        Log::error("Stok produk {$produk->nama} tidak cukup. Stok: {$produk->stok}, Qty: {$item->jumlah}");
                        throw new \Exception("Stok produk {$produk->nama} tidak cukup");
                    }

                    // Mengurangi stok
                    $produk->decrement('stok', $item->jumlah);

                    Log::info("Stok produk {$produk->nama} dikurangi {$item->jumlah}. Sisa: " . ($produk->stok - $item->jumlah));
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

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal memproses callback Midtrans untuk order {$pesanan->order_code}: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
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


    public function cancel($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        // Ubah status pengiriman menjadi dibatalkan
        $order->shipping_status = 'cancelled';
        $order->save();

        return redirect()->route('products.index')
            ->with('error', 'Pesanan telah dibatalkan.');
    }
}
