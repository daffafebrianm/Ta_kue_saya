<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->paginate(10);
        return view('admin.order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('user', 'orderDetails.produk')->findOrFail($id);
        return view('admin.order.show', compact('order'));
    }
}
