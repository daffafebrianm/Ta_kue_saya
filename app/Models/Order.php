<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'totalharga',
        'nama',
        'payment_status',
        'phone_number',
        'shipping_status',
        'shipping_method',
        'alamat',
        'order_code',
        'order_date',
        'note',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class,'order_id');
    }

    public function products()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
