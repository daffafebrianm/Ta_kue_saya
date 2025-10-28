<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks'; // 👈 WAJIB ini

    protected $fillable = [
        'id_kategori',
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'berat',
        'status',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'berat' => 'decimal:2',
        'stok'  => 'integer',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id'); 
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details', 'product_id', 'order_id')
            ->withPivot(['jumlah', 'harga', 'total'])
            ->withTimestamps();
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class); // order_details.product_id
    }

    public function keranjang()
    {
        return $this->hasMany(Kategori::class);
    }
    // Hanya produk aktif
    public function scopeAktif($q)
    {
        return $q->where('status', 'aktif');
    }
}
