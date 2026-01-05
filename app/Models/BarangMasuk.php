<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuks';

    protected $fillable = [
        'id_produk',
        'tanggal_masuk',
        'jumlah',
        'harga_modal',
        'harga_jual',
        'keterangan',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
