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
        Schema::table('order_details', function (Blueprint $table) {
            $table->decimal('harga_modal', 15, 2)->after('harga')->nullable();
            $table->decimal('laba', 15, 2)->after('total')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn(['harga_modal', 'laba']);
        });
    }
};
