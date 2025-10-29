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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // relasi ke user
            $table->string('order_code', 50); // kode pesanan unik
            $table->string('nama', 100);
            $table->text('alamat'); // alamat pengiriman
            $table->string('phone_number', 20);
            $table->decimal('totalharga', 15, 2); // total harga
            $table->enum('payment_status', ['pending', 'paid'])->default('pending'); // status pembayaran
            $table->enum('shipping_status', ['pending', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending'); // status pengiriman
            $table->enum('shipping_method', ['picked up','delivered']); // metode pengiriman
            $table->text('note')->nullable(); // catatan tambahan
            $table->date('order_date'); // catatan tambahan
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
