<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', // Relasi ke tabel orders
        'produk_id', // Relasi ke produk
        'jumlah',
        'harga',
        'harga_modal',
        'total',
        'laba',

    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
