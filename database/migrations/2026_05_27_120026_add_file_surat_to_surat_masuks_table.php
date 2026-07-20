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
        // Cek dulu, kalau kolom 'file_surat' BELUM ada, baru tambahkan
        if (Schema::hasTable('surat_masuks') && !Schema::hasColumn('surat_masuks', 'file_surat')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                // Di controller bersifat required, jika di DB ingin opsional tetap gunakan nullable()
                $table->string('file_surat')->nullable()->after('perihal'); 
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cek dulu apakah tabel dan kolomnya ada sebelum di-drop agar tidak error saat rollback
        if (Schema::hasTable('surat_masuks') && Schema::hasColumn('surat_masuks', 'file_surat')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->dropColumn('file_surat');
            });
        }
    }
};