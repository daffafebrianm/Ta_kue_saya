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

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);
            $table->dropColumn(['order_id','product_id']);
        });
    }
};
