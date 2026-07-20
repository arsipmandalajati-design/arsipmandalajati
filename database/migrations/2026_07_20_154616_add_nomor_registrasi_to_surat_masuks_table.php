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
            // Cek dulu, kalau kolom 'nomor_registrasi' BELUM ADA, baru ditambahkan
            if (!Schema::hasColumn('surat_masuks', 'nomor_registrasi')) {
                Schema::table('surat_masuks', function (Blueprint $table) {
                    // Ditempatkan setelah 'id' atau setelah 'nomor_urut' agar struktur registrasi berurutan
                    $table->string('nomor_registrasi')->nullable()->after('id'); 
                });
            } else {
                // Skenario JIKA kolom sudah ada dan Anda hanya ingin mengubah sifatnya menjadi nullable
                Schema::table('surat_masuks', function (Blueprint $table) {
                    $table->string('nomor_registrasi')->nullable()->change();
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
                // Hapus kolom hanya jika kolom tersebut benar-benar ada di database
                if (Schema::hasColumn('surat_masuks', 'nomor_registrasi')) {
                    $table->dropColumn('nomor_registrasi');
                }
            });
        }
    }
};