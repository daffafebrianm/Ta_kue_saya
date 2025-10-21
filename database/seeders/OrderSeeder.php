<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Produk;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $user = User::first(); // ambil user pertama
        $produk = Produk::first(); // ambil produk pertama

        if ($user && $produk) {
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $produk->harga,
                'payment_status' => 'pending',
                'shipping_status' => 'pending',
                'shipping_method' => 'JNE',
                'tracking_number' => Str::upper(Str::random(10)),
                'alamat' => 'Jl. Contoh No.1, Jakarta',
                'order_code' => 'ORD-' . strtoupper(Str::random(6)),
                'note' => 'Pesanan untuk test'
            ]);

            OrderDetail::create([
                'order_id' => $order->id,
                'produk_id' => $produk->id,
                'jumlah' => 1,
                'harga' => $produk->harga,
                'total' => $produk->harga
            ]);
        }
    }
}
