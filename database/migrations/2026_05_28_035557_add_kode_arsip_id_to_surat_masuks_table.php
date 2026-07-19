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
        // Cek dulu, kalau kolom 'kode_arsip_id' BELUM ada, baru tambahkan
        if (!Schema::hasColumn('surat_masuks', 'kode_arsip_id')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->foreignId('kode_arsip_id')->nullable()->constrained('kode_arsips')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            $table->dropForeign(['kode_arsip_id']);
            $table->dropColumn('kode_arsip_id');
        });
    }
};