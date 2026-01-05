<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $orders = Order::with('user')
            ->when($search, function ($query, $search) {
                $query->where('order_code', 'like', "%{$search}%");
            })
            ->orderBy('order_date', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.order.index', compact('orders', 'search'));
    }


    public function show($id)
    {
        $order = Order::with('user', 'orderDetails.produk')->findOrFail($id);
        return view('admin.order.show', compact('order'));
    }
}
