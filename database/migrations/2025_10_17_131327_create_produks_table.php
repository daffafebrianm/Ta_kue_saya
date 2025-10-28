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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kategori'); // bigint (foreign key ke tabel kategori)
            $table->string('nama', 150); // varchar(150)
            $table->text('deskripsi'); // text
            $table->decimal('harga', 15, 2); // decimal(15,2)
            $table->integer('stok'); // int
            $table->string('gambar', 255)->nullable(); // varchar(255), boleh kosong
            $table->decimal('berat', 10, 2); // decimal(10,2)
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif'); // enum
            $table->timestamps();

            $table->foreign('id_kategori')->references('id')->on('kategoris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
