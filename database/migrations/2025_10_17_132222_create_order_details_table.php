<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // relasi ke tabel pesanan
            $table->unsignedBigInteger('produk_id'); // relasi ke tabel produk
            $table->integer('jumlah'); // jumlah produk
            $table->decimal('harga', 15, 2); // harga satuan
            $table->decimal('total', 15, 2); // total harga (harga * jumlah)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
