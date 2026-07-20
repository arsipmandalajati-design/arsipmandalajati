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
        if (Schema::hasTable('surat_masuks')) {
            // Cek dulu, kalau kolom 'nomor_urut' BELUM ADA, baru ditambahkan
            if (!Schema::hasColumn('surat_masuks', 'nomor_urut')) {
                Schema::table('surat_masuks', function (Blueprint $table) {
                    // Ditempatkan setelah kode_arsip_id sesuai kebutuhanmu
                    $table->integer('nomor_urut')->nullable()->after('kode_arsip_id'); 
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('surat_masuks')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                // Hapus kolom hanya jika kolom tersebut benar-benar ada
                if (Schema::hasColumn('surat_masuks', 'nomor_urut')) {
                    $table->dropColumn('nomor_urut');
                }
            });
        }
    }
};