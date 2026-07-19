<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    // Cek dulu, kalau kolom 'judul' BELUM ada, baru tambahkan
    if (!Schema::hasColumn('surat_masuks', 'judul')) {
        Schema::table('surat_masuks', function (Blueprint $table) {
            $table->string('judul')->nullable(); // sesuaikan dengan tipe data asli kamu jika bukan string
        });
    }
}

    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {

            $table->dropColumn('judul');

        });
    }
};