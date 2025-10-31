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
            ->orderByDesc('order_date')
            ->paginate(10);

        return view('user.Riwayat-Pesanan.index', compact('orders'));
    }
}
