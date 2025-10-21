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
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // relasi ke tabel users
            $table->string('type', 100); // tipe notifikasi (contoh: 'pembayaran', 'pengiriman')
            $table->text('message'); // isi pesan notifikasi
            $table->enum('status', ['unread', 'read'])->default('unread'); // status baca
            $table->timestamp('read_at')->nullable(); // waktu dibaca
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
