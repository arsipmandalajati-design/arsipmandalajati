<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah kolom 'catatan_admin' sudah ada di tabel
        if (Schema::hasColumn('surat_masuks', 'catatan_admin')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->text('catatan_admin')->nullable()->change();
            });
        } else {
            // Jika belum ada, buat langsung tanpa peduli posisi 'after' kolom lain
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->text('catatan_admin')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            if (Schema::hasColumn('surat_masuks', 'catatan_admin')) {
                $table->text('catatan_admin')->nullable(false)->change();
            }
        });
    }
};