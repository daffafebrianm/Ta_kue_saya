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
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_produk');
            $table->date('tanggal_masuk');
            $table->integer('jumlah'); // jumlah barang masuk
            $table->decimal('harga_modal', 15, 2);
            $table->decimal('harga_jual', 15, 2);
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // Foreign key ke tabel produk
            $table->foreign('id_produk')
                ->references('id')
                ->on('produks')
                ->onDelete('cascade'); // hapus otomatis jika produk dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
