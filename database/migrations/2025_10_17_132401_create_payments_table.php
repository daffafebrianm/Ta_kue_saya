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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // relasi ke tabel pesanan
            $table->string('payment_method', 100); // metode pembayaran (contoh: transfer, e-wallet)
            $table->string('transaksi_id', 100)->nullable(); // ID transaksi dari gateway pembayaran
            $table->decimal('amount', 15, 2); // nominal pembayaran
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending'); // status pembayaran
            $table->timestamp('paid_at')->nullable(); // waktu pembayaran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
