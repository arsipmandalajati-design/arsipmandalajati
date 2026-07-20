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
            // Pengecekan kolom dilakukan DI LUAR callback Schema::table agar query builder Laravel tidak bingung
            if (!Schema::hasColumn('surat_masuks', 'jumlah_peserta')) {
                Schema::table('surat_masuks', function (Blueprint $table) {
                    // Diberi default 0 agar data lama yang sudah ada tidak error/kosong
                    $table->integer('jumlah_peserta')->default(0)->after('file_surat');
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
            if (Schema::hasColumn('surat_masuks', 'jumlah_peserta')) {
                Schema::table('surat_masuks', function (Blueprint $table) {
                    $table->dropColumn('jumlah_peserta');
                });
            }
        }
    }
};