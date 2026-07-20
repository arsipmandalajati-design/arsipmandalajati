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
        // Cek apakah tabelnya ada dan kolom 'judul' BELUM ada
        if (Schema::hasTable('surat_masuks') && !Schema::hasColumn('surat_masuks', 'judul')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                // Di controller bersifat required. Kita posisikan setelah nomor_surat/nomor_registrasi agar rapi
                $table->string('judul')->after('nomor_surat'); 
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cek dulu apakah tabel dan kolomnya ada sebelum menghapus kolom
        if (Schema::hasTable('surat_masuks') && Schema::hasColumn('surat_masuks', 'judul')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->dropColumn('judul');
            });
        }
    }
};