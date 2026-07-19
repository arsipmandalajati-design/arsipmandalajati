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
    if (!Schema::hasColumn('surat_masuks', 'file_surat')) {
        Schema::table('surat_masuks', function (Blueprint $table) {
            $table->string('file_surat')->nullable(); // sesuaikan dengan kode asli kamu
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {

            $table->dropColumn('file_surat');

        });
    }
};
