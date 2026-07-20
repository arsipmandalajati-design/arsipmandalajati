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
        // Cek apakah tabelnya ada dan kolomnya BELUM ada
        if (Schema::hasTable('surat_masuks') && !Schema::hasColumn('surat_masuks', 'kode_arsip_id')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                // Di controller kolom ini required saat relasi, 
                // dibuat nullable di DB untuk menjaga kecocokan data lama (jika ada)
                $table->foreignId('kode_arsip_id')
                      ->nullable()
                      ->after('user_id') // Posisikan setelah user_id agar struktur DB rapi
                      ->constrained('kode_arsips')
                      ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cek dulu apakah tabel dan kolomnya ada sebelum menghapus foreign key & kolom
        if (Schema::hasTable('surat_masuks') && Schema::hasColumn('surat_masuks', 'kode_arsip_id')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->dropForeign(['kode_arsip_id']);
                $table->dropColumn('kode_arsip_id');
            });
        }
    }
};