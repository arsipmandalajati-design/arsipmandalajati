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
                if (!Schema::hasColumn('surat_masuks', 'tempat')) {
                    $table->string('tempat')->nullable()->after('file_surat');
                }
                
                if (!Schema::hasColumn('surat_masuks', 'tanggal_kegiatan')) {
                    $table->date('tanggal_kegiatan')->nullable()->after('tempat');
                }
                
                if (!Schema::hasColumn('surat_masuks', 'jam_mulai')) {
                    $table->time('jam_mulai')->nullable()->after('tanggal_kegiatan');
                }
                
                if (!Schema::hasColumn('surat_masuks', 'jam_selesai')) {
                    $table->time('jam_selesai')->nullable()->after('jam_mulai');
                }
                
                if (!Schema::hasColumn('surat_masuks', 'materi')) {
                    $table->text('materi')->nullable()->after('jam_selesai');
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
                foreach (['tempat', 'tanggal_kegiatan', 'jam_mulai', 'jam_selesai', 'materi'] as $col) {
                    if (Schema::hasColumn('surat_masuks', $col)) {
                        $columnsToDrop[] = $col;
                    }
                }

                // Eksekusi drop hanya jika ada kolom yang terdaftar
                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
                
            });
        }
    }
};