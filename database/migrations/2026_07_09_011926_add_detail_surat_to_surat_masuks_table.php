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
            Schema::table('surat_masuks', function (Blueprint $table) {

                // Tambahkan pengecekan per kolom agar tidak error jika sudah ada sebagian
                if (!Schema::hasColumn('surat_masuks', 'jenis_surat')) {
                    $table->string('jenis_surat')
                          ->nullable()
                          ->after('kode_arsip_id');
                }

                if (!Schema::hasColumn('surat_masuks', 'sumber_arsip')) {
                    $table->string('sumber_arsip')
                          ->nullable()
                          ->after('jenis_surat');
                }

                if (!Schema::hasColumn('surat_masuks', 'nomor_manual')) {
                    $table->string('nomor_manual')
                          ->nullable()
                          ->after('nomor_surat');
                }

            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('surat_masuks')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                
                // Kumpulkan kolom yang benar-benar ada sebelum di-drop
                $columnsToDrop = [];
                foreach (['jenis_surat', 'sumber_arsip', 'nomor_manual'] as $col) {
                    if (Schema::hasColumn('surat_masuks', $col)) {
                        $columnsToDrop[] = $col;
                    }
                }

                // Eksekusi drop hanya jika ada kolom yang terdeteksi
                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
                
            });
        }
    }
};