<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            // Kolom jumlah_peserta hanya dibuat JIKA belum ada di database
            if (!Schema::hasColumn('surat_masuks', 'jumlah_peserta')) {
                $table->integer('jumlah_peserta')->default(0);
            }

            // Tulis kolom lain di bawah sini jika memang ada yang mau ditambah
            // Contoh:
            // if (!Schema::hasColumn('surat_masuks', 'tanggal_booking')) {
            //     $table->date('tanggal_booking')->nullable();
            // }
        });
    }

    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            if (Schema::hasColumn('surat_masuks', 'jumlah_peserta')) {
                $table->dropColumn('jumlah_peserta');
            }
        });
    }
};