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
            $table->decimal('total', 15, 2); // total harga
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending'); // status pembayaran
            $table->enum('shipping_status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending'); // status pengiriman
            $table->string('shipping_method', 100)->nullable(); // metode pengiriman
            $table->string('tracking_number', 100)->nullable(); // nomor resi
            $table->text('alamat'); // alamat pengiriman
            $table->string('order_code', 50)->unique(); // kode pesanan unik
            $table->text('note')->nullable(); // catatan tambahan
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
