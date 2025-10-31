<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
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
        // dd($order->orderDetails);

        // Debug untuk memastikan data sudah benar
        // dd($order);

        // Jika pesanan tidak ditemukan atau tidak milik user yang login
        if (!$order) {
            return redirect()->route('user.orders.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Kirim data pesanan ke view
        return view('user.pembayaran.index', compact('order'));
    }


}
