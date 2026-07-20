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
        // Cek apakah tabel ada dan kolom 'status_disposisi' BELUM ada
        if (Schema::hasTable('surat_masuks') && !Schema::hasColumn('surat_masuks', 'status_disposisi')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                // Diposisikan setelah kolom file_surat agar struktur DB tetap rapi
                $table->string('status_disposisi')->nullable()->after('file_surat'); 
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cek dulu apakah tabel dan kolom 'status_disposisi' benar-benar ada sebelum di-drop
        if (Schema::hasTable('surat_masuks') && Schema::hasColumn('surat_masuks', 'status_disposisi')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->dropColumn('status_disposisi'); // Nama kolom disamakan dengan fungsi up()
            });
        }
    }
};