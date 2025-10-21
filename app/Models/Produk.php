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

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
