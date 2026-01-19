<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class RiwayatPesananController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderDetails.produk')
            ->where('user_id', Auth::id())
            ->whereIn('payment_status', ['paid', 'success', 'settlement'])
            ->orderByDesc('order_date')
            ->paginate(9);

        return view('user.Riwayat-Pesanan.index', compact('orders'));
    }
    public function show($id)
    {
        $order = Order::with(['orderDetails.produk'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.Riwayat-Pesanan.detail', compact('order'));
    }
}
